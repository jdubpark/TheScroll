'use strict';

const
  env = require('../../universal/env'),
  express = require('express'),
  isNodeProd = env.NODE_ENV === 'production',
  // http = isNodeProd ? require('https') : require('http'),
  http = require('http'),
  helmet = require('helmet'),
  Promise = require('bluebird'),
  cors = require('cors'),
  app = express(),
  // dbcon = require('./helper/mysql'),
  Article = require('./helper/article'),
  // Metadata = require('./helper/metadata'),
  Teaser = require('./helper/teaser'),
  port = env.port.main;

const
  corsWhitelist = ['http://localhost', 'http://localhost:3000', 'http://localhost:3000/website/TheScroll/public/', 'https://deerfieldscroll.com', 'http://deerfieldscroll.com', 'http://beta.deerfieldscroll.com'],
  corsOptions = {
    origin: (origin, callback) => {
      if (corsWhitelist.indexOf(origin) !== -1) callback(null, true);
      else callback(new Error('CORS'));
    },
    optionsSuccessStatus: 200, // some legacy browsers (IE11, various SmartTVs) choke on 204
  };

// let storedMtdt = {};

app.use(helmet());
// app.use(cors(corsOptions)); // only for prod (blocks Postman)
app.use(express.json());
app.use(express.urlencoded({extended: true}));

// Metadata.recurLoad(storedMtdt);

app.get('/api/article/:id', (req, res, next) => {
  try {
    const
      articleId = String(req.params.id).trim();

    Article.find(articleId)
      .then(response => {
        // console.log(response);
        if (response.status === 'article-found') response.payload = Article.syntaxT1(response.payload);
        res.status(200).json(response);
      }).catch(err => next(new Error(err)));
  } catch (err){
    next(new Error(err));
  }
});

// app.get('/api/articles/:limitCount?/:limitStart?', (req, res, next) => {
//   try {
//     const limitCount = req.params.limitCount || 5;
//     let limitStart = String(req.params.limitStart).trim();
//     if (limitStart === 'undefined') limitStart = 0;
//
//     Article.findMany(limitCount, limitStart)
//       .then(response => {
//         if (response.status === 'articles-found'){
//           response.payload = response.payload.map((article, key) => {
//             return Article.syntaxT1(article);
//           });
//         }
//         res.status(200).json(response);
//       }).catch(err => next(new Error(err)));
//   } catch (err){
//     next(new Error(err));
//   }
// });

// app.get('/api/metadata', (req, res, next) => {
//   try {
//     const response = {
//       error: '',
//       status: 'metadata-found',
//       payload: storedMtdt,
//     };
//     res.status(200).json(response);
//   } catch (err){
//     next(new Error(err));
//   }
// });

app.get('/api/teasers/all', (req, res, next) => {
  try {
    Teaser.all()
      .then(response => {
        // if (response.status === 'teaser-generated'){
        //   response.payload = Teaser.organizeColumns(response.payload);
        // }
        res.status(200).json(response);
      }).catch(err => next(new Error(err)));
  } catch (err){
    next(new Error(err));
  }
});

app.get('/api/teasers/section/:sectionId', (req, res, next) => {
  try {
    const
      sectionId = req.params.sectionId,
      pageNum = req.body.pageNum || 1,
      perPage = req.body.perPage || 20;
    // console.log(req.body);

    Teaser.section(sectionId, pageNum, perPage)
      .then(response => {
        // if (response.status === 'teaser-generated'){
        //   response.payload = Teaser.organizeArticles(response.payload);
        //   response.payload.section = Object.keys(response.payload.bySection)[0];
        //   delete response.payload.bySection;
        // }
        // console.log(response);
        res.status(200).json(response);
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
  console.log('[TheScroll: Main API] listening at http://%s:%s', host, cport);
});
