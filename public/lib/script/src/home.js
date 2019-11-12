const pako = require('pako');

axios.get('http://localhost:1289/api/teasers/all')
  .then(res => {
    const data = JSON.parse(pako.inflate(res.data, {to: 'string'}));
    // console.log(data);
    const {articles: {articles}, columns} = data;
    loadMainTextonly(columns.main.textonly, articles);
    loadMainFocus(articles[columns.main.focus1], articles[columns.main.focus2]);
    loadMainStep1(columns.main.step1, articles);
    loadMainStep2(columns.main.step2, articles);
  })
  .catch(err => {
    console.error(err);
  });

function loadEachSection(section, list, articles){
  section = section.toLowerCase();
  const focus = articles[list.focus], $section = $(`#content-section-${section}`);
  $section.html('');
  let template = '<div class="article article-t4a">'+
    `<div class="article-t4a-cover-image"></div>`+
    '<div class="article-t4a-content">'+
      `<div class="article-t4a-section"></div>`+
      `<div class="article-t4a-headline"></div>`+
      `<div class="article-t4a-summary"></div>`+
    '</div>'+
  '</div>';
  $section.append(template);
  list.textonly.forEach(id => {
    const article = articles[id];
    template = '<div class="article article-t4b">'+
      '<div class="article-t4b-content">'+
        `<div class="article-t4a-section">${article.section}</div>`+
        `<a href="./article.php?id=${id}" class="article-t4b-headline">${article.title}</a>`+
        `<a href="./article.php?id=${id}" class="article-t4b-summary">${article.summary}</a>`+
      '</div>'+
    '</div>';
    $section.append(template);
  });
}

function loadMainTextonly(list, articles){
  $('#content-main-textonly').html('');
  list.forEach(id => {
    const
      article = articles[id],
      template = '<div class="article article-t1a">'+
        '<div class="article-t1a-content">'+
          `<a class="article-t1a-section">${article.section}</a>`+
          `<a href="./article.php?id=${id}" class="article-t1a-headline">${article.title}</a>`+
          `<a href="./article.php?id=${id}" class="article-t1a-summary">${article.summary}</a>`+
        '</div>'+
      '</div>';
    $('#content-main-textonly').append(template);
  });
}

function loadMainStep1(list, articles){
  $('#content-main-step1').html('');
  list.forEach(id => {
    const
      article = articles[id],
      template = '<div class="layout-block layout-3-12">'+
        '<div class="article article-t2">'+
          `<a href="./article.php?id=${id}" class="article-t2-cover-image" style="background-image:url('${article.coverImage.link}');"></a>`+
          '<div class="article-t2-content">'+
            `<div class="article-t2-section">${article.section}</div>`+
            `<a href="./article.php?id=${id}" class="article-t2-headline">${article.title}</a>`+
            `<a href="./article.php?id=${id}" class="article-t2-summary">${article.summary}</a>`+
          '</div>'+
        '</div>'+
      '</div>';
    $('#content-main-step1').append(template);
  });
}

function loadMainStep2(list, articles){
  $('#content-main-step2').html('');
  const focus = articles[list.focus];
  let template = '<div class="layout-block layout-4--5-12">'+
    '<div class="article article-t3a">'+
      '<div class="article-t3a-cover-image-wrapper">'+
        `<a href="./article.php?id=${focus.id}" class="article-t3a-cover-image" style="background-image:url('${focus.coverImage.link}');"></a>`+
      '</div>'+
      '<div class="article-t3a-content">'+
        `<div class="article-t3a-section">${focus.section}</div>`+
        `<a href="./article.php?id=${focus.id}" class="article-t3a-headline">${focus.title}</a>`+
        `<a href="./article.php?id=${focus.id}" class="article-t3a-summary">${focus.summary}</a>`+
      '</div>'+
    '</div>'+
  '</div>';
  $('#content-main-step2').append(template);
  list.else.forEach(id => {
    const article = articles[id];
    template = '<div class="layout-block layout-2--5-12">'+
      '<div class="article article-t3b">'+
        `<div class="article-t3b-section">${article.section}</div>`+
        `<a href="./article.php?id=${id}" class="article-t3b-cover-image" style="background-image:url('${article.coverImage.link}');"></a>`+
        '<div class="article-t3b-content">'+
          `<a href="./article.php?id=${id}" class="article-t3b-headline">${article.title}</a>`+
          `<a href="./article.php?id=${id}" class="article-t3a-summary">${article.summary}</a>`+
        '</div>'+
      '</div>'+
    '</div>';
    $('#content-main-step2').append(template);
  });
}

function loadMainFocus(focus1, focus2){
  $('#content-main-focus1').html('');
  $('#content-main-focus2').html('');
  const
    template1 = '<div class="article article-t1b">'+
      `<a href="./article.php?id=${focus1.id}" class="article-t1b-cover-image" style="background-image:url('${focus1.coverImage.link}');"></a>`+
      '<div class="article-t1b-content">'+
        `<div class="article-t1b-section">${focus1.section}</div>`+
        `<a href="./article.php?id=${focus1.id}" class="article-t1b-headline">${focus1.title}</a>`+
        `<a href="./article.php?id=${focus1.id}" class="article-t1b-summary">${focus1.summary}</a>`+
      '</div>'+
    '</div>',
    template2 = '<div class="article article-t1c">'+
      '<div class="article-t1c-cover-image-wrapper">'+
        `<a href="./article.php?id=${focus2.id}" class="article-t1c-cover-image" style="background-image:url('${focus2.coverImage.link}');"></a>`+
      '</div>'+
      '<div class="article-t1c-content">'+
        `<div class="article-t1c-section">${focus2.section}</div>`+
        `<a href="./article.php?id=${focus2.id}" class="article-t1c-headline">${focus2.title}</a>`+
        `<a href="./article.php?id=${focus2.id}" class="article-t1c-summary">${focus2.summary}</a>`+
      '</div>'+
    '</div>';
  $('#content-main-focus1').html(template1);
  $('#content-main-focus2').html(template2);
}
