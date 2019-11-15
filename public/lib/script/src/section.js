let teaserUrl = 'http://localhost:1289/api/teasers/all';
if (process.env.NODE_ENV === 'production' && location.hostname !== 'localhost') teaserUrl = 'http://beta.deerfieldscroll.com/api/teasers/all';

axios.get(teaserUrl)
  .then(res => {
    // const data = JSON.parse(pako.inflate(res.data, {to: 'string'}));
    console.log(res.data);
    const {articles: {articles}, columns} = res.data.payload;
    loadMain(columns.main, articles);
    loadMainStep1(columns.main.step1, articles);
    loadMainStep2(columns.main.step2, articles);
    loadAllSection(columns.sections, articles);
  })
  .catch(err => {
    console.error(err);
  });
