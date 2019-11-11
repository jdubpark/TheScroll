const
  env = require('../../../universal/env'),
  WPAPI = require('wpapi');

const wp = new WPAPI({
  endpoint: env.wp.endpoint,
  username: env.wp.user,
  password: env.wp.pass,
  auth: true,
});

module.exports = class Fetcher{
  static categories(){
    return new Promise((resolve, reject) => {
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

  static posts(num, categories){
    return new Promise((resolve, reject) => {
      wp.posts().perPage(50)
        .then(articles => {
          // console.log(articles);
          // console.log(categories);
          const cleaned = articles.map(article => {
            const {date, title: {rendered: title}} = article;
            let category = article.categories[0];
            // console.log(title, category, categories[String(category)]);
            if (categories) category = categories[String(category)];
            return {date, title, category};
          });
          resolve(cleaned);
        })
        .catch(err => {
          console.log(err);
          reject(err);
        });
    });
  }
};
