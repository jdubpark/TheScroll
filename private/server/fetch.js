'use strict';

const
  env = require('../../universal/env'),
  WPAPI = require('wpapi'),
  Fetcher = require('./helper/fetcher');

// const wp = new WPAPI({
//   endpoint: env.wp.endpoint,
//   username: env.wp.user,
//   password: env.wp.pass,
//   auth: true,
// });

Fetcher.categories()
  .then(categories => {
    // console.log(categories);

    Fetcher.posts(50, categories)
      .then(articles => {
        console.log(articles);
      })
      .catch(err => {
        console.log(err);
      });
  })
  .catch(err => {
    console.log(err);
  });

// wp.categories()
//   .then(categories => {
//     const catCleaned = {};
//     delete categories._paging;
//     categories.forEach(category => {
//       const {id, count, name} = category;
//       catCleaned[category.id] = {id, count, name};
//     });
//     console.log(catCleaned);
//
//     wp.posts().perPage(50)
//       .then(articles => {
//         // console.log(articles);
//         articles.forEach(article => {
//           console.log(article.date, article.title.rendered);
//         });
//       })
//       .catch(err => {
//         console.log(err);
//       });
//   })
//   .catch(err => {
//     console.log(err);
//   });
