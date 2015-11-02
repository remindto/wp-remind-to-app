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

    function scrollToOldSpot(e){
      e.preventDefault();
      var selector = getDecodedQueryParam('slr');
      var indx = parseInt(getDecodedQueryParam('sdx'), 10);
      var el = document.querySelectorAll(selector)[indx];
      var elDistrace = el.offsetTop + (window.innerHeight - (window.innerHeight/2));
      // console.log(selector);
      // console.log(indx);
      // console.log(el);
      // console.log(elDistrace);
      // console.log(window.scrollY);

      hideContinueBarForever();
      temporarilyHideAds();

      jQuery('html, body').animate({
           'scrollTop': elDistrace
      }, 500, 'swing');

      window.setTimeout(function(){
        el.classList.add('highlight-yellow');
      }, 700);
    }

    function temporarilyHideAds(){
      var hideAds = document.createElement('style');
      hideAds.innerHTML = " .content-ad-wrapper{display: none !important; }";
      hideAds.className = "tempHideAds";
      var headTag = document.querySelector('head');
      headTag.appendChild(hideAds);
      window.setTimeout(function(){
        document.addEventListener("touchmove", reengageAds, false);
        document.addEventListener("scroll", reengageAds, false);
      }, 750);
    }

    function reengageAds(){
      document.removeEventListener("touchmove", reengageAds, false);
      document.removeEventListener("scroll", reengageAds, false);
      window.setTimeout(function(){
        document.querySelector('.tempHideAds').remove();
      }, 15000);
      window.setTimeout(function(){
        document.querySelector('.highlight-yellow').classList.remove('highlight-yellow');
      }, 1000);
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
