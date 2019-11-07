const
  env = require('../../../universal/env'),
  mysql = require('mysql2');

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
    console.error('[TheScroll: Main API] MySQL Error Connecting: ' + err.stack);
    return;
  }
  console.log('[TheScroll: Main API] MySQL Connected as id ' + dbcon.threadId);
});

module.exports = dbcon;
