const
  env = require('../../../universal/env'),
  APIHelper = require('../../api/helper/shared'),
  WPAPI = require('wpapi');

module.exports = class Fetcher extends APIHelper{
  static categories(){
    return new Promise((resolve, reject) => {
      const wp = new WPAPI({
        endpoint: env.wp.endpoint,
        username: env.wp.user,
        password: env.wp.pass,
        auth: true,
      });
      // just set it to 100 to get all categories
      wp.categories().perPage(100)
        .then(categories => {
          const cleaned = {};
          // console.log(categories);
          delete categories._paging;
          categories.forEach(category => {
            const {id, count, name} = category;
            cleaned[category.id] = {id, count, name};
          });
          resolve(cleaned);
        })
        .catch(err => {
          console.log(err);
          reject(err);
        });
    });
  }

  static posts(categories, num=100, cleanup=true){
    return new Promise((resolve, reject) => {
      const wp = new WPAPI({
        endpoint: env.wp.endpoint,
        username: env.wp.user,
        password: env.wp.pass,
        auth: true,
      });
      wp.posts().perPage(num).order('desc').orderby('date')
        .then(articles => {
          const cleaned = this.organizeWPArticles(articles, false, categories);
          resolve(cleaned);
        })
        .catch(err => {
          console.log(err);
          reject(err);
        });
    });
  }
};
