const
  env = require('../../../universal/env'),
  mysql = require('mysql2'),
  CronJob = require('cron').CronJob;

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
    console.error('[TheScroll: Main API - Metadata] MySQL Error Connecting: ' + err.stack);
    return;
  }
  console.log('[TheScroll: Main API - Metadata] MySQL Connected as id ' + dbcon.threadId);
});

const isRecurSet = false;

module.exports = class Metadata{
  static recurCron = new CronJob('0 0 * * * *', () => {}, null, true, 'America/Los_Angeles');

  static recurLoad(toChange){
    if (isRecurSet) return;
    isRecurSet = true;
    this.recurCron.fireOnTick(() => toChange = this.load());
    this.recurCron.start();
  }

  static recurLoadCancel(){
    isRecurSet = false;
    this.recurCron.stop();
  }

  static load(){
    // mysql.
  }
};
