const
  env = require('../../../universal/env'),
  HelperShared = require('./shared'),
  WPAPI = require('wpapi');

module.exports = class Teaser extends HelperShared{
  static all(){
    return new Promise((resolve, reject) => {
      try {
        const response = {error: '', status: '', payload: {}};
        const wp = new WPAPI({
          endpoint: env.wp.endpoint,
          username: env.wp.user,
          password: env.wp.pass,
          auth: true,
        });
        wp.posts().perPage(50)
          .then(articles => {
            console.log(articles.length);
            // const cleaned = this.syntax(articles);
            if (articles.length > 0){
              // response.status = 'teaser-generated';
              response.payload = articles;
            }
            resolve(response.payload.length);
            // resolve(cleaned);
          })
          .catch(err => {
            console.log(err);
          });
      } catch (err){
        reject(err);
      }
    });
  }
};
