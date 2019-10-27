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
    console.error('[TheScroll: Article API] MySQL Error Connecting: ' + err.stack);
    return;
  }
  console.log('[TheScroll: Article API] MySQL Connected as id ' + dbcon.threadId);
});

module.exports = class Article{
  static find(articleId){
    return new Promise((resolve, reject) => {
      try {
        const response = {error: '', status: '', payload: {}};
        if (!(/^\d+$/.test(articleId))){
          response.error = 'invalid-id-syntax';
          response.status = 'error';
          resolve(response);
        } else {
          // only show published articles
          const query =
            'SELECT t1.id, t1.author_display, t1.time_published, t2.summary, t3.content, t4.link as image_link, t4.caption as image_caption,'+
            ' t5.link as video_link, t5.caption as video_caption, GROUP_CONCAT(NULLIF(t6.section_name, "") separator ",") as section FROM ArticleT1 t1'+
            ' LEFT JOIN SummaryT1 t2 ON t2.article_id = t1.id'+
            ' LEFT JOIN ContentT1 t3 ON t3.article_id = t1.id'+
            ' LEFT JOIN ImageCoverT1 t4 ON t4.article_id = t1.id'+
            ' LEFT JOIN VideoCoverT1 t5 ON t5.article_id = t1.id'+
            ' LEFT JOIN ('+ // get all section names
            '   SELECT t6s1.article_id, t6s1.section_id, t6s2.name as section_name FROM SectionT1 t6s1'+
            '   LEFT JOIN ('+
            '     SELECT id, name FROM Sections'+
            '   ) t6s2 ON t6s2.id = t6s1.section_id'+
            ' ) t6 ON t6.article_id = t1.id'+
            ' WHERE t1.id = ? AND t1.published = 1 GROUP BY t1.id';
            // GROUP BY t1.id ignores GROUP_CONCAT returning a NULL row
          // ' LEFT JOIN CommentT1 t6 ON t6.article_id = t1.id ';

          dbcon.query(query, [articleId], (err, article, fields) => {
            if (err) reject(err);
            if (article.length === 0){
              response.status = 'article-not-found';
              resolve(response);
            } else {
              response.status = 'article-found';
              response.payload = article[0];
              resolve(response);
            }
          });
        }
      } catch (err){
        reject(err);
      }
    });
  }

  static findMany(limitCount, limitStart = 0){
    return new Promise((resolve, reject) => {
      try {
        const response = {error: '', status: '', payload: {}};
        if (!(/^\d+$/.test(limitCount)) || !(/^\d+$/.test(limitStart))){
          response.error = 'invalid-limit-syntax';
          response.status = 'error';
          resolve(response);
        } else {
          // only show published articles
          // in case of tied time published, order by time created (desc)
          const query =
            'SELECT t1.id, t1.author_display, t1.time_published, t2.summary, t3.content, t4.link as image_link, t4.caption as image_caption,'+
            ' t5.link as video_link, t5.caption as video_caption, GROUP_CONCAT(t6.section_name separator ",") as section FROM ArticleT1 t1'+
            ' LEFT JOIN SummaryT1 t2 ON t2.article_id = t1.id'+
            ' LEFT JOIN ContentT1 t3 ON t3.article_id = t1.id'+
            ' LEFT JOIN ImageCoverT1 t4 ON t4.article_id = t1.id'+
            ' LEFT JOIN VideoCoverT1 t5 ON t5.article_id = t1.id'+
            ' LEFT JOIN ('+ // get all section names
            '   SELECT t6s1.article_id, t6s1.section_id, t6s2.name as section_name FROM SectionT1 t6s1'+
            '   LEFT JOIN ('+
            '     SELECT id, name FROM Sections'+
            '   ) t6s2 ON t6s2.id = t6s1.section_id'+
            ' ) t6 ON t6.article_id = t1.id'+
            ' WHERE t1.published = 1 GROUP BY t1.id'+ // group by t1.id to prevent all results from combining into one result
            ' ORDER BY t1.time_published DESC, t1.time_created DESC LIMIT ?, ?';
          // ' LEFT JOIN CommentT1 t6 ON t6.article_id = t1.id ';
          // LIMIT ?, ? -- https://stackoverflow.com/questions/8805538/how-to-select-n-records-from-a-table-in-mysql

          dbcon.query(query, [Number(limitStart), Number(limitCount)], (err, articles, fields) => {
            if (err) reject(err);
            // console.log(articles);
            if (articles.length === 0){
              response.status = 'articles-not-found';
              resolve(response);
            } else {
              response.status = 'articles-found';
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

  static syntaxT1(article){
    return {
      id: article.id,
      author: article.author_display,
      section: article.section.split(','),
      summary: article.summary,
      content: article.content,
      coverImage: {
        link: article.image_link,
        caption: article.image_caption,
      },
      coverVideo: {
        exists: article.video_link !== '',
        link: article.video_link,
        caption: article.video_caption,
      },
      published: article.time_published,
    };
  }
};
