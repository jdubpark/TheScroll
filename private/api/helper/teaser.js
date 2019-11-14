const
  env = require('../../../universal/env'),
  mysql = require('mysql2'),
  WPAPI = require('wpapi'), // http://wp-api.org/node-wpapi/using-the-client/
  HelperShared = require('./shared');

let dbcon;

function handleMysql(){
  // Recreate the connection, since the old one cannot be reused.
  dbcon = mysql.createConnection({
    host: env.db.host,
    user: env.db.user,
    password: env.db.pass,
    database: env.db.name,
  });

  dbcon.connect(err => {
    if (err){
      console.error('[TheScroll: Main API - Article] MySQL Error Connecting: ' + err.stack);
      setTimeout(handleMysql, 2000);
    }
    console.log('[TheScroll: Main API - Article] MySQL Connected as id ' + dbcon.threadId);
  });

  dbcon.on('error', err => {
    console.error('[TheScroll: Main API - Article] MySQL Error: ' + err.stack);
    if (err.code === 'PROTOCOL_CONNECTION_LOST') handleMysql();
  });
}

handleMysql();

module.exports = class Teaser extends HelperShared{
  static all(){
    return new Promise((resolve, reject) => {
      try {
        const
          response = {error: '', status: '', payload: {}},
          query = 'SELECT `value` FROM DataT1 WHERE `key` = "teasers";';

        dbcon.query(query, (err, data, fields) => {
          if (err) console.log(err);
          else response.payload = JSON.parse(data[0]['value']);
          resolve(response);
        });
      } catch (err){
        reject(err);
      }
    });
  }

  static section(sectionId, pageNum=1, perPage=20){
    return new Promise((resolve, reject) => {
      try {
        const
          response = {error: '', status: '', payload: {}},
          wp = new WPAPI({
            endpoint: env.wp.endpoint,
            username: env.wp.user,
            password: env.wp.pass,
            auth: true,
          }),
          query = 'SELECT `value` FROM DataT1 WHERE `key` = "categories";';

        if (!(/^\d+$/.test(sectionId)) || !(/^\d+$/.test(pageNum)) || !(/^\d+$/.test(perPage))){
          response.error = 'invalid-param-syntax';
          response.status = 'error';
          resolve(response);
        } else {
          let sectionData = {id: sectionId};
          // get category name
          dbcon.query(query, (err, data, fields) => {
            if (err) console.log(err);
            else {
              const categories = JSON.parse(data[0].value);
              sectionData = categories[sectionId] || {id: sectionId};
            }
          });
          // wp post
          wp.posts().categories(sectionId).perPage(perPage).page(pageNum).order('desc').orderby('date')
            .then(articles => {
              const
                cleaned = this.organizeWPArticles(articles, true, null),
                focus = [], textonly = [], other = [];
              Object.keys(cleaned).forEach(id => {
                delete cleaned[id].content;
                const article = cleaned[id];
                if (article.coverImage.exists){
                  if (focus.length < 4) focus.push(id);
                  else other.push(id);
                } else textonly.push(id);
              });
              response.payload = {articles: cleaned, focus, textonly, other, section: sectionData}
              resolve(response);
            })
            .catch(err => {
              console.log(err);
              response.error = 'internal-error';
              response.status = 'error';
              resolve(response);
            });
        }
      } catch (err){
        reject(err);
      }
    });
  }
};
