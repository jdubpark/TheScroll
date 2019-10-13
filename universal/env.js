require('dotenv').config({path: __dirname + '/../.env'});

module.exports = {
  NODE_ENV: process.env.DAS_NODE_ENV,
  port: {
    main: process.env.DAS_PORT_MAIN,
  },
  host: {
    main: process.env.DAS_HOST_MAIN,
  },
  db: {
    host: process.env.DAS_DB_HOST,
    name: process.env.DAS_DB_NAME,
    user: process.env.DAS_DB_USER,
    pass: process.env.DAS_DB_PASS,
  }
};
