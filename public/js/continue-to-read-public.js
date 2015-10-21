;(function(){
  function CFPApp(){

    blastOff();

    function blastOff(){
      // console.log('blastOff');
      if(window.location.href.indexOf('slr') != -1 && window.location.href.indexOf('sdx') != -1){
        document.querySelector('.return-to-spot-wrapper').classList.add('viewable');
        setupEvents();
      }
    }

    function getQueryString( field, url ) {
      var href = url ? url : window.location.href;
      var reg = new RegExp( '[?&]' + field + '=([^&#]*)', 'i' );
      var string = reg.exec(href);
      return string ? string[1] : null;
    }

    function getDecodedQueryParam(param){
      return decodeURIComponent(getQueryString(param));
    }

    function scrollToOldSpot(){
      var selector = getDecodedQueryParam('slr');
      var indx = parseInt(getDecodedQueryParam('sdx'), 10);
      var el = document.querySelectorAll(selector)[indx];
      var elDistrace = el.getBoundingClientRect().top - 200;
      // console.log(selector);
      // console.log(indx);
      // console.log(el);
      // console.log(elDistrace);
      // console.log(window.scrollY);
      if(window.scrollY !== 0){
        elDistrace = elDistrace + window.scrollY;
        // console.log('Updated: ', elDistrace);
      }
      hideContinueBarForever();

      temporarilyHideAds();

      jQuery('html, body').animate({
           'scrollTop': elDistrace
      }, 400, 'swing');

      window.setTimeout(function(){
        el.classList.add('highlight-yellow');
      }, 500);
    }

    function temporarilyHideAds(){
      var hideAds = document.createElement('style');
      hideAds.innerHTML = " .content-ad-wrapper{display: none !important; }";
      hideAds.id = "tempHideAds";
      var headTag = document.querySelector('head');
      headTag.appendChild(hideAds);
      window.setTimeout(function(){
        document.querySelector('#tempHideAds').remove();
      }, 750);
    }

    function hideContinueBarForever(){
      document.querySelector('.return-to-spot-wrapper').classList.add('hideforever');
    }

    function hideContinueBar(){
      document.querySelector('.return-to-spot-wrapper').classList.remove('viewable');
    }

    function setupEvents(){
      // console.log('setupEvents');
      var remindMeLaterButton = document.querySelector('.sendlater-container button'),
                 returnToSpot = document.querySelector('.return-to-spot'),
            returnToSpotClose = document.querySelector('.return-to-spot .close-icon');

        returnToSpot.addEventListener('click', scrollToOldSpot, false);
        returnToSpot.addEventListener('touchstart', scrollToOldSpot, false);
        returnToSpotClose.addEventListener('click', hideContinueBar, false);
        returnToSpotClose.addEventListener('touchstart', hideContinueBar, false);
    }

  }

  TNY.CFPApp = CFPApp;
})();

jQuery(document).ready(function(){
  if(jQuery('.return-to-spot-wrapper').length > 0){
    TNY.CFPApp();
  }
});
