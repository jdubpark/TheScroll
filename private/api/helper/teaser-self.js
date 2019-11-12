const
  env = require('../../../universal/env'),
  mysql = require('mysql2'),
  HelperShared = require('./shared');

// NOTE:
// consider pool for performance boost
const dbcon = mysql.createConnection({
  host: env.db.host,
  user: env.db.user,
  password: env.db.pass,
  database: env.db.name,
});
dbcon.connect(err => {
  if (err){
    console.error('[TheScroll: Main API - Article] MySQL Error Connecting: ' + err.stack);
    return;
  }
  console.log('[TheScroll: Main API - Article] MySQL Connected as id ' + dbcon.threadId);
});

module.exports = class Teaser extends HelperShared{
  static all(){
    return new Promise((resolve, reject) => {
      try {
        const response = {error: '', status: '', payload: {}};
        const query =
          'SELECT t1.id, t1.author_display, t1.title, t2.summary, t4.link as image_link, t4.caption as image_caption,'+
          ' t1.published, t1.time_published, t5.link as video_link, t5.caption as video_caption, t6.name as section FROM ('+
          '   SELECT'+
          '     id, title, author_display, published, time_published, section_id,'+
          '     @rownum := IF(@prev = section_id, @rownum + 1, 1) AS rownum,'+
          '     @prev := section_id'+
          '   FROM ArticleT1'+
          '   JOIN (SELECT @prev := NULL, @rownum := 0) AS vars'+
          '   ORDER BY section_id, time_published DESC, id DESC'+
          ' ) AS t1'+
          ' LEFT JOIN SummaryT1 t2 ON t2.article_id = t1.id'+
          ' LEFT JOIN ImageCoverT1 t4 ON t4.article_id = t1.id'+
          ' LEFT JOIN VideoCoverT1 t5 ON t5.article_id = t1.id'+
          ' LEFT JOIN Sections t6 ON t6.id = t1.section_id'+
          ' WHERE t1.published = 1 AND t1.rownum <= 15';

        dbcon.query(query, (err, articles, fields) => {
          if (err) reject(err);
          // console.log(articles);
          if (articles.length === 0){
            response.status = 'teaser-not-generated';
            resolve(response);
          } else {
            response.status = 'teaser-generated';
            response.payload = articles;
            resolve(response);
          }
        });
      } catch (err){
        reject(err);
      }
    });
  }

  static section(sectionId, limitCount = 20, limitStart = 0){
    return new Promise((resolve, reject) => {
      try {
        const response = {error: '', status: '', payload: {}};
        if (!(/^\d+$/.test(sectionId))){
          response.error = 'invalid-section-id-syntax';
          response.status = 'error';
          resolve(response);
        } else if ((!(/^\d+$/.test(limitCount)) || limitCount > 20) || !(/^\d+$/.test(limitStart))){
          response.error = 'invalid-limit-syntax';
          response.status = 'error';
          resolve(response);
        } else {
          // only show published articles
          // in case of tied time published, order by time created (desc)
          const query =
            'SELECT t1.id, t1.author_display, t1.title, t2.summary, t4.link as image_link, t4.caption as image_caption, t1.published,'+
            ' t1.section_id, t1.time_published, t5.link as video_link, t5.caption as video_caption, t6.name as section FROM ArticleT1 as t1'+
            ' LEFT JOIN SummaryT1 t2 ON t2.article_id = t1.id'+
            ' LEFT JOIN ImageCoverT1 t4 ON t4.article_id = t1.id'+
            ' LEFT JOIN VideoCoverT1 t5 ON t5.article_id = t1.id'+
            ' LEFT JOIN Sections t6 ON t6.id = t1.section_id'+
            ' WHERE t1.published = 1 AND t1.section_id = ?'+
            ' ORDER BY t1.time_published DESC, t1.time_created DESC LIMIT ?, ?';

          dbcon.query(query, [sectionId, Number(limitStart), Number(limitCount)], (err, articles, fields) => {
            if (err) reject(err);
            // console.log(articles);
            if (articles.length === 0){
              response.status = 'teaser-not-generated';
              resolve(response);
            } else {
              response.status = 'teaser-generated';
              response.payload = articles;
              resolve(response);
            }
          });
        }
      } catch (err){
        reject(err);
      }
    });
  }

  static organizeArticles(rawData){
    const
      articles = {},
      bySection = {},
      byCover = {exist: [], noexist: []},
      byDate = {};

    rawData.map((article, key) => {
      const
        clean = this.syntaxT1(article),
        {id, section} = clean;
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
      const ids = articles.bySection[sectionName], section = {...sectionSyntax};
      let needSection = 7;
      // console.log(sectionName, ids);
      for (let i = 0; i < ids.length && (needSection > 0 || section.focus === null); i++){
        const id = ids[i];
        // check if id can be used
        // console.log(id, this.useId(idsLeft, id), idsLeft);
        if (!this.useId(idsLeft, id)) return;
        // check if focus is occupied yet
        if (section.focus === null && articles.articles[id].coverImage.exists) section.focus = id;
        else section.textonly.push(id);
        // decrease need & remove the used id from idsLeft list
        needSection -= 1;
        this.removeId(idsLeft, id);
      }
      columns.sections[sectionName] = section;
    });

    return {articles, columns};
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
};
