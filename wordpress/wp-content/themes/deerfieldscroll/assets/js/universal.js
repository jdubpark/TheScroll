'use strict';

const
  stockIndiceTargets = {
    '^DJI': 'DJIA',
    '^SPX': 'S&P500',
    '^NYA': 'NYSE',
    '^TNX': 'US10Y',
    '^RUT': 'Russell2000',
  },
  stockIndiceFix = {'^DJI': 2, '^SPX': 2, '^NYA': 2, '^TNX': 4, '^RUT': 2},
  $stockIndiceTargets = {};

let updateStockLoop = null;
const updateStockInterval = 60000; // 1 min

function fetchStocks($){
  return new Promise((resolve, reject) => {
    const request = $.ajax({
      url: 'https://api.coinwis.com/trivial/composite-indice',
      method: 'GET',
      dataType: 'json',
    });
    request.always(() => console.log(new Date()+' :: Fetching Stock Price'));
    request.done((data, textStatus, jqXHR) => {
      // console.log(data);
      resolve(data);
    });
    request.fail((jqXHR, textStatus, err) => {
      console.log(err);
      reject(err);
    });
  });
  return promise.then(res => {
    // console.log(res);
    return res;
  }).catch(err => {
    console.log(err);
  });
}

function updateStocks($){
  fetchStocks($)
    .then(data => {
      const symbols = Object.keys(data);
      symbols.forEach(symbol => updateStockTicker(symbol, data[symbol]));
    })
    .catch(err => console.log(err));
  // update every set interval
  updateStockLoop = setTimeout($ => updateStocks($), updateStockInterval);
}

function updateStockTicker(symbol, data){
  const
    $target = $stockIndiceTargets[symbol],
    fixVal = stockIndiceFix[symbol],
    changePerc = Number.parseFloat(data['changePerc']);

  // ignore non-existing ones
  if (!$target || !$target.parent.length) return;

  // update values
  $target.value.html(Number.parseFloat(data['price']).toFixed(fixVal));
  $target.change.html(changePerc.toFixed(2)+'%');
  // change color
  if (changePerc > 0) $target.parent.removeClass('down').addClass('up');
  else if (changePerc < 0) $target.parent.removeClass('up').addClass('down');
  else $target.parent.removeClass('up down');
}

(function($){
  console.log('universal script loaded');
  // http://coinwis.com/api/trivial/composite-indice

  $(document).ready(function(){
    const targets = Object.keys(stockIndiceTargets);
    targets.forEach(symbol => {
      const target = stockIndiceTargets[symbol];
      const $parent = $(`[stock-ticker="${target}"]`);
      $stockIndiceTargets[symbol] = {
        parent: $parent,
        value: $parent.children('.stock-ticker-value'),
        change: $parent.children('.stock-ticker-change'),
      };
    });

    updateStocks($);
  });

  $(document).on('click', '#site-nav-menu-trigger', function(){
    const $t = $(this);
    if ($t.hasClass('active')){
      $t.removeClass('active');
      $('#site-nav-menu').removeClass('open');
    } else {
      $t.addClass('active');
      $('#site-nav-menu').addClass('open');
    }
  });
})(jQuery);
