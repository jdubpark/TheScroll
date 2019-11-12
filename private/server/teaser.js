'use strict';

const
  env = require('../../universal/env'),
  WPAPI = require('wpapi'),
  mysql = require('mysql2'),
  pako = require('pako'),
  CronJob = require('cron').CronJob,
  Fetcher = require('./helper/fetcher'),
  APIHelper = require('../api/helper/shared');

const dbcon = mysql.createConnection({
  host: env.db.host,
  user: env.db.user,
  password: env.db.pass,
  database: env.db.name,
});
dbcon.connect(err => {
  if (err){
    console.error('[TheScroll: Server - Teaser] MySQL Error Connecting: ' + err.stack);
    return;
  }
  console.log('[TheScroll: Server - Teaser] MySQL Connected as id ' + dbcon.threadId);
});

class TeaserFetch extends APIHelper{
  static fetchAll(){
    Fetcher.categories()
      .then(categories => {
        categories['2'].name = categories['2'].name.replace(/&amp;/g, '&');

        Fetcher.posts(categories, 100, false)
          .then(articles => {
            // remove unnecessary fields
            Object.keys(articles).forEach(id => {
              delete articles[id].content;
              delete articles[id].related;
            });

            const
              organized = this.organizeColumns(articles),
              query1 = 'UPDATE DataT1 SET `value` = ? WHERE `key` = "teasers";',
              query2 = 'UPDATE DataT1 SET `value` = ? WHERE `key` = "categories";';

            organized.idsLeft.forEach(id => delete organized.articles.articles[id]);

            delete organized.articles.bySection;
            delete organized.articles.byCover;
            delete organized.articles.byDate;
            delete organized.idsLeft;

            // console.log(Object.keys(organized.articles.articles).length);
            const binaryString = pako.deflate(JSON.stringify(organized), {to: 'string'});
            // console.log(binaryString);
            dbcon.query(query1, [binaryString], (err, result, fields) => {
              if (err) console.log(err);
            });
            dbcon.query(query2, [JSON.stringify(categories)], (err, result, fields) => {
              if (err) console.log(err);
            });
          })
          .catch(err => {
            console.log(err);
          });
      })
      .catch(err => {
        console.log(err);
      });
  }

  static organizeArticles(rawData){
    const
      articles = {},
      bySection = {},
      byCover = {exist: [], noexist: []},
      byDate = {};

    Object.keys(rawData).forEach(id => {
      const
        article = rawData[id],
        clean = this.syntaxTeaser(article),
        {section} = clean;

      if (typeof bySection[section] === 'undefined') bySection[section] = [];
      if (typeof byDate[clean.published.code] === 'undefined') byDate[clean.published.code] = [];
      bySection[section].push(id);
      byCover[clean.coverImage.exists ? 'exist' : 'noexist'].push(id);
      byDate[clean.published.code].push(id);

      delete clean.content; // don't need for teaser
      articles[id] = clean;
    });
    return {articles, bySection, byCover, byDate};
  }

  // organize columns
  static organizeColumns(rawData){
    const
      articles = this.organizeArticles(rawData),
      idsLeft = Object.keys(articles.articles),
      columns = {
        main: {
          textonly: [],
          focus1: null,
          focus2: null,
          step1: [],
          step2: {
            focus: null,
            else: [],
          },
        },
        sections: {},
      },
      sectionSyntax = {
        focus: null,
        textonly: [],
      };
    // wc: with cover, woc: without cover
    let needMainWC = 10, needMainWOC = 3;

    // organize articles with cover
    articles.byCover.exist.some(id => {
      // console.log(id, this.useId(idsLeft, id), idsLeft);
      if (!this.useId(idsLeft, id)) return;
      if (columns.main.focus1 === null) columns.main.focus1 = id;
      else if (columns.main.focus2 === null) columns.main.focus2 = id;
      else {
        // check if step1 is filled
        if (columns.main.step1.length < 4) columns.main.step1.push(id);
        else {
          // check if step2.focus is filled
          if (columns.main.step2.focus === null) columns.main.step2.focus = id;
          else columns.main.step2.else.push(id);
        }
      }
      needMainWC -= 1;
      this.removeId(idsLeft, id);
      return needMainWC <= 0; // do until need is 0
    });

    // organize articles without cover
    articles.byCover.noexist.some(id => {
      columns.main.textonly.push(id);
      needMainWOC -= 1;
      return needMainWOC <= 0; // do until need is 0
    });

    // MUST BE LAST - organize section columns
    Object.keys(articles.bySection).forEach(sectionName => {
      const ids = articles.bySection[sectionName];
      let section = {...sectionSyntax}, needSection = 7;
      // console.log(sectionName, ids);
      for (let i = 0; i < ids.length && needSection > 0; i++){
        const id = ids[i];
        // check if id can be used
        // console.log(id, this.useId(idsLeft, id), idsLeft);
        // console.log(sectionName, id, this.useId(idsLeft, id));
        if (!this.useId(idsLeft, id)) continue;
        // check if focus is occupied yet
        if (section.focus === null && articles.articles[id].coverImage.exists) section.focus = id;
        else section.textonly.push(id);
        // decrease need & remove the used id from idsLeft list
        needSection -= 1;
        this.removeId(idsLeft, id);
      }
      // lazy, just loop all and cut any extra
      // if (section.textonly.length > needSection) section.textonly = section.textonly.slice(0, needSection);
      // assign the value back
      columns.sections[sectionName] = section;
    });

    return {articles, columns, idsLeft};
  }

  static useId(ids, id){
    // convert to string to use as key
    return ids.includes(String(id));
  }

  static removeId(ids, id){
    // convert to string to use as key
    // return what is removed
    return ids.splice(ids.indexOf(String(id)), 1);
  }
}

TeaserFetch.fetchAll();
// every hour
const recurCron = new CronJob('0 0 * * * *', () => {
  console.log('fetching at '+new Date());
  TeaserFetch.fetchAll();
}, null, true, 'America/Los_Angeles');

recurCron.start();
