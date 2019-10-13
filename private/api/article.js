'use strict';

const
  env = require('../../universal/env'),
  express = require('express'),
  isNodeProd = env.NODE_ENV === 'production',
  http = isNodeProd ? require('https') : require('http'),
  mysql = require('mysql2'),
  helmet = require('helmet'),
  Promise = require('bluebird'),
  cors = require('cors'),
  app = express(),
  port = env.port.main;

const
  corsWhitelist = ['http://localhost', 'http://localhost:3000', 'https://thescroll.com'],
  corsOptions = {
    origin: (origin, callback) => {
      if (corsWhitelist.indexOf(origin) !== -1) callback(null, true);
      else callback(new Error('CORS'));
    },
    optionsSuccessStatus: 200, // some legacy browsers (IE11, various SmartTVs) choke on 204
  };

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

app.use(helmet());
// app.use(cors(corsOptions));
app.use(express.json());
app.use(express.urlencoded({extended: true}));

app.get('/article/:id', (req, res, next) => {
  try {
    const
      response = {payload: {}},
      articleId = String(req.params.id).trim();

    new Promise((resolve, reject) => {
      if (!(/^\d+$/.test(articleId))){
        response.payload = {error: 'invalid-id-syntax'};
        resolve(response);
      } else {
        // this query is for public
        const
          queryArticle = 'SELECT id, author_display, section, time_created_display FROM ArticleT1 WHERE id = ?',
          querySummary = 'SELECT summary FROM SummaryT1 WHERE article_id = ?',
          queryContent = 'SELECT content FROM ContentT1 WHERE article_id = ?',
          queryImageCover = 'SELECT image_link FROM ImageCoverT1 WHERE article_id = ?',
          // purpose of public: (later) allow viewers to post anonymous comments
          queryComment = 'SELECT name, email, comment FROM CommentT1 WHERE public = 1 AND banned = 0 AND article_id = ?',
          // executed after queryArticle
          afterQueries = [querySummary, queryContent, queryImageCover, queryComment];

        response.payload.article = {
          metadata: {},
          summary: '',
          content: {},
          comment: [],
        };

        dbcon.query(queryArticle, [articleId], (err, article, fields) => {
          if (err) reject(err);
          // console.log(article);
          response.status = 'article-found';
          if (article.length === 0){
            response.status = 'article-not-found';
            resolve(response);
          }
          else {
            // article is found, save & proceed to the next queries
            response.payload.article.metadata = article[0];
            // bind queries into promise
            const promises = afterQueries.map((query, index) => {
              return new Promise((resolve, reject) => {
                dbcon.query(query, [articleId], (err, results) => {
                  if (err) reject(err);
                  resolve(results);
                });
              });
            });
            // wait for all
            Promise.all(promises).then(results => {
              console.log(results);
              // return
              resolve(response);
            }).catch(err => next(new Error(err)));
          }
        });
      }
    }).then(_response => {
      res.status(200).json(_response);
    }).catch(err => next(new Error(err)));
  } catch (err){
    next(new Error(err));
  }
});

// MUST BE AT LAST
// to catch all errors
// custom error handler
app.use((err, req, res, next) => {
  console.log(err);
  const errMsg = err.message;
  if (errMsg === 'CORS'){
    res.status(422).json({error: 'unprocessable-entity'});
    return;
  }
  res.status(500).json({error: 'internal-error'});
});

http.createServer(app).listen(port, function(){
  const addr = this.address(), host = addr.address, cport = addr.port;
  console.log('[TheScroll: Article API] listening at http://%s:%s', host, cport);
});
