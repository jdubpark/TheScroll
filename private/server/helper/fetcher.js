const
  env = require('../../../universal/env'),
  APIHelper = require('../../api/helper/shared'),
  WPAPI = require('wpapi');

const wp = new WPAPI({
  endpoint: env.wp.endpoint,
  username: env.wp.user,
  password: env.wp.pass,
  auth: true,
});

module.exports = class Fetcher extends APIHelper{
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

  static posts(categories, num=100, cleanup=true){
    return new Promise((resolve, reject) => {
      wp.posts().perPage(num)
        .then(articles => {
          delete articles._paging;
          // console.log(articles);
          // console.log(categories);
          const final = {};
          articles.forEach(article => {
            const {id} = article;
            let inSyntax = article;

            if (cleanup){
              const related = article['jetpack-related-posts'].map(article => this.syntaxRelated(article));

              inSyntax = this.syntax(article);
              inSyntax.related = related;
            }

            if (categories){
              const category = categories[String(article.categories[0])];
              // console.log(id, category);
              article.categories = [category.name];
            }

            final[id] = inSyntax;
          });
          resolve(final);
        })
        .catch(err => {
          console.log(err);
          reject(err);
        });
    });
  }
};
