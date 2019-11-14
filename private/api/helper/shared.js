const
  dateNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
  monthNames = {
    short: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    long: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
  };

module.exports = class HelperShared{
  static formatDate(time){
    const
      dateObj = new Date(time),
      date = dateObj.getDay(),
      day = dateObj.getDate(),
      dayLast = day[day.len-1],
      dayExt = dayLast === '1' ? 'st' : dayLast === '2' ? 'nd' : dayLast === '3' ? 'rd' : 'th',
      monthIndex = dateObj.getMonth(),
      year = dateObj.getFullYear();
    return {
      dateObj,
      extended: `${dateNames[date]}, ${monthNames.short[monthIndex]} ${day+dayExt}, ${year}`,
      readable: `${monthNames.long[monthIndex]} ${day+dayExt}, ${year}`,
      short: `${monthNames.short[monthIndex]} ${day+dayExt}, ${year}`,
      code: `${year}-${monthIndex+1}-${day}`,
    };
  }

  static syntax(raw){
    const coverLink = raw['jetpack_featured_media_url'];

    return {
      id: raw.id,
      title: raw.title.rendered,
      author: 'author', // need author meta support
      section: raw.categories[0],
      summary: raw.excerpt.rendered,
      content: raw.content.rendered,
      coverImage: {
        exists: coverLink !== '',
        link: coverLink,
        caption: '',
      },
      published: this.formatDate(raw.date),
    };
  }

  static syntaxTeaser(raw){
    const coverLink = raw['jetpack_featured_media_url'];
    return {
      id: raw.id,
      title: raw.title.rendered,
      author: 'author', // need author meta support
      section: raw.categories[0],
      summary: raw.excerpt.rendered,
      coverImage: {
        exists: coverLink !== '',
        link: coverLink,
        caption: '',
      },
      published: this.formatDate(raw.date),
    };
  }

  static syntaxRelated(raw){
    const
      coverImage = raw.img || {src: ''},
      section = /\“(\w.*?)\”/g.exec(raw.context) || ['', ''];

    if (coverImage.src !== '' && coverImage.src.slice(0, 4) !== 'http') coverImage.src = 'http://deerfieldscroll.com'+coverImage.src;
    return {
      id: raw.id,
      title: raw.title,
      // author: '',
      section: section[1],
      summary: raw.excerpt,
      coverImage: {
        exists: coverImage.src !== '',
        link: coverImage.src,
        caption: '',
      },
      published: this.formatDate(raw.date),
    };
  }

  static organizeWPArticles(articles, cleanup=false, categories=null, getRelated=false){
    delete articles._paging;
    // console.log(articles);
    // console.log(categories);
    const final = {};
    // console.log(articles);
    articles.forEach(article => {
      const {id} = article;
      let inSyntax = article;
      // console.log(article.id, article.date);

      if (cleanup){
        if (getRelated){
          const related = article['jetpack-related-posts'].map(article => this.syntaxRelated(article));
          inSyntax = this.syntax(article);
          inSyntax.related = related;
        } else {
          inSyntax = this.syntax(article);
        }
      }

      if (categories !== null){
        const category = categories[String(article.categories[0])];
        // console.log(id, category);
        article.categories = [category.name];
      }

      // add space at the front to prevent automatic numeric key sorting
      final['i'+id] = inSyntax;
    });
    // console.log(final);
    return final;
  }
};
