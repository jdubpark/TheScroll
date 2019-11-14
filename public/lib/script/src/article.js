let teaserUrl = `http://localhost:1289/api/article/${articleId}`;
if (process.env.NODE_ENV === 'production' && location.hostname !== 'localhost') teaserUrl = `http://beta.deerfieldscroll.com/api/article/${articleId}`;

axios.get(teaserUrl)
  .then(res => {
    console.log(res);
    const article = res.data;
    let htmlHeader = '', htmlMeta = '', htmlRelated = '';

    // header
    htmlHeader = '<div class="arf-block">'+
      `<div id="article-title" class="arf-hd-title">${article.title}</div>`+
      `<div id="article-summary" class="arf-hd-summary">${article.summary}</div>`+
    '</div>';
    if (article.coverImage.exists){
      htmlHeader += '<div id="article-hd-cover" class="arf-hd-cover">'+
        `<div id="article-cover-image" class="arf-hd-cover-image"><img src="${article.coverImage.link}" /></div>`+
        '<div class="arf-hd-cover-caption"></div>'+
      '</div>';
    }
    document.getElementById('article-header').innerHTML = htmlHeader;

    // meta
    htmlMeta = '<div id="article-meta-one" class="arf-mt-row">'+
      `<div id="article-author" class="arf-mt-item arf-mt-author">${article.author}</div>`+
      `<div class="arf-mt-item arf-mt-published">Published <span id="article-published">${article.published.extended}</span></div>`+
    '</div>';
    document.getElementById('article-meta').innerHTML = htmlMeta;

    // content
    document.getElementById('article-content').innerHTML = article.content;

    // related
    htmlRelated += '<div class="arv-mr-header arv-mr-hd">'+
      '<div class="arv-mr-hd-title">More to read</div>'+
    '</div>'+
    '<div id="article-related" class="arv-mr-content arv-mr-ct">';
    article.related.forEach(relArticle => {
      const id = relArticle.id;
      let coverImage;
      if (relArticle.coverImage.exists) coverImage = `<a href="./article.php?id=${id}" class="arv-mr-ar-img" style="background-image:url(${relArticle.coverImage.link});"></a>`;
      else coverImage = '';

      htmlRelated += '<div class="arv-mr-article">'+
        `${coverImage}`+
        `<div class="arv-mr-ar-section">${relArticle.section}</div>`+
        `<a href="./article.php?id=${id}" class="arv-mr-ar-headline">${relArticle.title}</a>`+
        `<div class="arv-mr-ar-published">${relArticle.published.short}</div>`+
      '</div>';
    });
    htmlRelated += '</div>';
    document.getElementById('article-related-wrapper').innerHTML = htmlRelated;
  })
  .catch(err => {
    console.error(err);
  })
