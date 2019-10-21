'use strict';

const
  env = require('../../universal/env'),
  express = require('express'),
  isNodeProd = env.NODE_ENV === 'production',
  http = isNodeProd ? require('https') : require('http'),
  helmet = require('helmet'),
  Promise = require('bluebird'),
  cors = require('cors'),
  app = express(),
  Article = require('./helper/article'),
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

app.use(helmet());
// app.use(cors(corsOptions));
app.use(express.json());
app.use(express.urlencoded({extended: true}));

app.get('/article/:id', (req, res, next) => {
  try {
    const
      articleId = String(req.params.id).trim();

    Article.find(articleId)
      .then(response => {
        response.payload = Article.syntaxT1(response.payload);
        res.status(200).json(response);
      }).catch(err => next(new Error(err)));
  } catch (err){
    next(new Error(err));
  }
});

app.get('/articles/:limitCount', (req, res, next) => {
  try {
    const limitCount = Number(req.params.limitCount);
    // let limitStart = String(req.params.limitStart).trim();
    // if (limitStart == null) limitStart = 0;

    Article.findMany(limitCount, 0)
      .then(response => {
        response.payload.map((article, key) => {
          console.log(article);
          return Article.syntaxT1(article);
        });
        console.log(response);
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
  console.log('[TheScroll: Article API] listening at http://%s:%s', host, cport);
});
