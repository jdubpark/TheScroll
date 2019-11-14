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

function fixImg(url, bigger=false){
  const size = bigger ? '800%2C600' : '400%2C300';
  return url.includes('wp.com') ? url : `https://i0.wp.com/${url.replace('http://', '')}?resize=${size}`;
}

function loadAllSection(sections, articles){
  Object.keys(sections).forEach(sectionName => {
    // console.log(sectionName);
    loadEachSection(sectionName, sections[sectionName], articles);
  });
}

function loadEachSection(section, list, articles){
  section = section.toLowerCase().replace('&', '-');
  const
    focus = articles[list.focus],
    name = `content-section-${section}`,
    $section = document.getElementById(name);
  if ($section === null) return;
  let html = '';

  html += `<div id="${name}-1" class="layout-block layout-4-12">`+
    '<div class="article article-t4a">'+
      `<a href="./article.php?id=${focus.id}" class="article-t4a-cover-image" style="background-image:url(${fixImg(focus.coverImage.link)})"></a>`+
      '<div class="article-t4a-content">'+
        `<div class="article-t4a-date">${focus.published.short}</div>`+
        `<a href="./article.php?id=${focus.id}" class="article-t4a-headline">${focus.title}</a>`+
        `<a href="./article.php?id=${focus.id}" class="article-t4a-summary">${focus.summary}</a>`+
      '</div>'+
    '</div>'+
  '</div>';

  for (let i = 0; i < 2; i++){
    html += `<div id="${name}-${i+2}" class="layout-block layout-4-12">`;
    list.textonly.slice(i*3, i*3+3).forEach(id => {
      const article = articles[id];
      html += '<div class="article article-t4b">'+
        '<div class="article-t4b-content">'+
          `<div class="article-t4a-date">${article.published.short}</div>`+
          `<a href="./article.php?id=${article.id}" class="article-t4b-headline">${article.title}</a>`+
          `<a href="./article.php?id=${article.id}" class="article-t4b-summary">${article.summary}</a>`+
        '</div>'+
      '</div>';
    });
    html += '</div>';
  }

  // console.log(html);
  $section.innerHTML = html;
}

function loadMain(mainList, articles){
  const
    $section = document.getElementById('content-main'),
    focus1 = articles[mainList.focus1],
    focus2 = articles[mainList.focus2];
  let html = '';

  // text only
  html += '<div id="content-main-textonly" class="layout-block layout-block-t1 layout-3--5-12">';
  mainList.textonly.forEach(id => {
    const article = articles[id];
    html += '<div class="article article-t1a">'+
      '<div class="article-t1a-content">'+
        `<a class="article-t1a-section">${article.section}</a>`+
        `<a href="./article.php?id=${article.id}" class="article-t1a-headline">${article.title}</a>`+
        `<a href="./article.php?id=${article.id}" class="article-t1a-summary">${article.summary}</a>`+
      '</div>'+
    '</div>';
  });
  html += '</div>';

  // focus 1
  html += '<div id="content-main-focus1" class="layout-block layout-block-t1 layout-4-12">';
  html += '<div class="article article-t1b">'+
    `<a href="./article.php?id=${focus1.id}" class="article-t1b-cover-image" style="background-image:url('${fixImg(focus1.coverImage.link)}');"></a>`+
    '<div class="article-t1b-content">'+
      `<div class="article-t1b-section">${focus1.section}</div>`+
      `<a href="./article.php?id=${focus1.id}" class="article-t1b-headline">${focus1.title}</a>`+
      `<a href="./article.php?id=${focus1.id}" class="article-t1b-summary">${focus1.summary}</a>`+
    '</div>'+
  '</div>';
  html += '</div>';

  // focus 2
  html += '<div id="content-main-focus2" class="layout-block layout-block-t1 layout-4--5-12">';
  html += '<div class="article article-t1c">'+
    '<div class="article-t1c-cover-image-wrapper">'+
      `<a href="./article.php?id=${focus2.id}" class="article-t1c-cover-image" style="background-image:url('${fixImg(focus2.coverImage.link, true)}');"></a>`+
    '</div>'+
    '<div class="article-t1c-content">'+
      `<div class="article-t1c-section">${focus2.section}</div>`+
      `<a href="./article.php?id=${focus2.id}" class="article-t1c-headline">${focus2.title}</a>`+
      `<a href="./article.php?id=${focus2.id}" class="article-t1c-summary">${focus2.summary}</a>`+
    '</div>'+
  '</div>';
  html += '</div>';

  $section.innerHTML = html;
}

function loadMainStep1(list, articles){
  const $section = document.getElementById('content-main-step1');
  let html = '';
  list.forEach(id => {
    const article = articles[id];
    html += '<div class="layout-block layout-3-12">'+
      '<div class="article article-t2">'+
        `<a href="./article.php?id=${article.id}" class="article-t2-cover-image" style="background-image:url('${fixImg(article.coverImage.link)}');"></a>`+
        '<div class="article-t2-content">'+
          `<div class="article-t2-section">${article.section}</div>`+
          `<a href="./article.php?id=${article.id}" class="article-t2-headline">${article.title}</a>`+
          `<a href="./article.php?id=${article.id}" class="article-t2-summary">${article.summary}</a>`+
        '</div>'+
      '</div>'+
    '</div>';
  });
  $section.innerHTML = html;
}

function loadMainStep2(list, articles){
  const
    $section = document.getElementById('content-main-step2'),
    focus = articles[list.focus];
  let html = '';

  // focus
  html += '<div class="layout-block layout-4--5-12">'+
    '<div class="article article-t3a">'+
      '<div class="article-t3a-cover-image-wrapper">'+
        `<a href="./article.php?id=${focus.id}" class="article-t3a-cover-image" style="background-image:url('${fixImg(focus.coverImage.link, true)}');"></a>`+
      '</div>'+
      '<div class="article-t3a-content">'+
        `<div class="article-t3a-section">${focus.section}</div>`+
        `<a href="./article.php?id=${focus.id}" class="article-t3a-headline">${focus.title}</a>`+
        `<a href="./article.php?id=${focus.id}" class="article-t3a-summary">${focus.summary}</a>`+
      '</div>'+
    '</div>'+
  '</div>';

  // else
  list.else.forEach(id => {
    const article = articles[id];
    html += '<div class="layout-block layout-2--5-12">'+
      '<div class="article article-t3b">'+
        `<div class="article-t3b-section">${article.section}</div>`+
        `<a href="./article.php?id=${article.id}" class="article-t3b-cover-image" style="background-image:url('${fixImg(article.coverImage.link)}');"></a>`+
        '<div class="article-t3b-content">'+
          `<a href="./article.php?id=${article.id}" class="article-t3b-headline">${article.title}</a>`+
          `<a href="./article.php?id=${article.id}" class="article-t3a-summary">${article.summary}</a>`+
        '</div>'+
      '</div>'+
    '</div>';
  });

  $section.innerHTML = html;
}
