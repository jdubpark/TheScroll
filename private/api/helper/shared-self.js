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
      extended: `${dateNames[date]}, ${monthNames.short[monthIndex]} ${day}${dayExt}, ${year}`,
      readable: `${day} ${monthNames.long[monthIndex]} ${year}`,
      code: `${year}-${monthIndex+1}-${day}`,
    };
  }

  static syntaxT1(article){
    return {
      id: article.id,
      title: article.title,
      author: article.author_display,
      section: article.section,
      summary: article.summary,
      content: article.content,
      coverImage: {
        exists: article.image_link !== null,
        link: article.image_link,
        caption: article.image_caption,
      },
      coverVideo: {
        exists: article.video_link !== null,
        link: article.video_link,
        caption: article.video_caption,
      },
      published: this.formatDate(article.time_published),
    };
  }
};
