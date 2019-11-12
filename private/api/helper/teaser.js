const
  env = require('../../../universal/env'),
  mysql = require('mysql2'),
  HelperShared = require('./shared');

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
        const
          response = {error: '', status: '', payload: {}},
          query = 'SELECT `value` FROM DataT1 WHERE `key` = "teasers";';

        dbcon.query(query, (err, data, fields) => {
          if (err){
            console.log(err);
            resolve({});
          } else {
            resolve(data[0]['value']);
          }
        });
      } catch (err){
        reject(err);
      }
    });
  }
};
