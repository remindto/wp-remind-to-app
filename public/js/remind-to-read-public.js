;(function($, document){
  function SLApp(){
    // console.log('SLApp');
    var _email = null,
        _url = location.href,
        _url_later = null,
        _el = document.querySelector('.sendlater-container'),
        _lastState = 'accept-email',
        _visible = false,
        _defaultTime = '1 minute',
        _selector = "#articleBody>p";

    blastOff();

    var eventAppeared     = new Event('remindtoread-appeared');
    var eventHovered      = new Event('remindtoread-hovered');
    var eventClicked      = new Event('remindtoread-clicked');
    var eventSubmitEmail  = new Event('remindtoread-submit-email');
    var eventChangedTime  = new Event('remindtoread-changed-time');
    var eventClosed       = new Event('remindtoread-closed');

    function blastOff(){
      // console.log('blastOff');
      if(CN.isMobile){
        _el.classList.add('sendlater-closed');
      } else {
        setupEvents();
      }
      check_is_touch();
    }

    function check_is_touch(){
      if(is_touch_device()){
        jQuery('body').addClass('is_touch');
      }
    }
    /**
     * Get the paragraph that is closest to the top of the window
     */
    function getTopParagraph(){
      var elP = document.querySelectorAll('#articleBody>p');
      var closestToTop = elP[0],
          fromTop,
          iObj = { indx: 0, el: false };

      for(i = 0; i < elP.length; i++){
        fromTop = elP[i].getBoundingClientRect().top;
        if(fromTop > 0 && fromTop < window.innerHeight){
          if(i > 3){
            iObj.indx = i-1;
          } else {
            iObj.indx = 0;
          }
        }
      }

      iObj.el = elP[iObj.indx];
      iObj.firstParagraph = elP[0].innerHTML;
      return iObj;
    }

    function setupEvents(){
      // console.log('setupEvents');
      document.addEventListener('scrollChangeToDown', function(){
        // console.log(_visible);
        if(_visible === true){
          hideWhileScrolling();
          // console.log('Running scrollChangeToDown');
        }
      });
      document.addEventListener('scrollChangeToUp', function(){
        // console.log(_visible);
        if(_visible === false){
          displayWhileScrolling();
          // console.log('Running scrollChangeToUp');
          document.dispatchEvent(eventAppeared);
        }
      });

      var remindMeLaterButton = document.querySelector('.sendlater-container button'),
        emailField = document.querySelector('.sendlater-container .sendlater-email-input-field'),
        emailSubmitForm = document.querySelector('.sendlater-container form'),
        remindClose = document.querySelector('.sendlater-move-right .close-icon'),
        scheduleTimeField = document.querySelector('.sendlater-container select');

        remindClose.addEventListener('click', function(evt){ evt.preventDefault(); closeModal(); }, false);
        remindClose.addEventListener('touchstart', function(evt){ evt.preventDefault(); closeModal(); }, false);
        remindMeLaterButton.addEventListener('click', handleClickSetup, false);
        remindMeLaterButton.addEventListener('touchstart', handleClickSetup, false);
        _el.addEventListener('mouseover', makeVisible, false);
        emailField.addEventListener('submit', preventSendLaterSubmitForm, false);
        emailSubmitForm.addEventListener('click', handleClickEmail, false);
        emailSubmitForm.addEventListener('touchstart', handleClickEmail, false);
        scheduleTimeField.addEventListener('change', handleClickTime, false);
    }

    function makeVisible(){
      displayWhileScrolling();
      document.dispatchEvent(eventHovered);
    }

    function hideWhileScrolling(){
      _visible = false;
      // console.log('hideWhileScrolling');
      // console.log('hideWhileScrolling');

      if(_el.classList.contains('viewable')){
        _el.classList.remove('viewable');
      } else {
        _el.className = 'sendlater-container';
      }
    }

    function displayWhileScrolling(){
      _visible = true;
      // console.log('displayWhileScrolling');
      if(!_el.classList.contains('viewable') ){
        _el.classList.add('viewable');
      }
    }

    function hideAfterSkipping(){
      // console.log('hideAfterSkipping');
      if(_el.classList.contains('viewable')){
        _el.classList.remove('viewable');
      }
      if(_el.classList.contains('select-time')){
        closeModal();
      }
    }

    function displayWhileSkipping(){
      // console.log('displayWhileSkipping');
      _el.classList.add('display-while-skipping','animated','fadeInDown');
    }

    function displayWhileReading(){
      // console.log('displayWhileReading');
    }

    function handleClickSetup(evt){
      // console.log('handleClickSetup');
      if(_lastState == 'select-time'){
        _el.classList.add('select-time');
      } else if(_lastState == 'accept-email'){
        _lastState = 'accept-email';
        _el.classList.add('accept-email');
        document.querySelector('.sendlater-email-input-field').focus();
      }
      document.dispatchEvent(eventClicked);
    }

    function inputFieldBlur(){
      jQuery('.is_touch .sendlater-container').css('top', 'auto');
    }

    function inputFieldFocus(){
      jQuery('.is_touch .sendlater-container').css('top', (window.scrollY - jQuery('.sendlater-container').height()) + 'px');
    }

    function is_touch_device() {
      return 'ontouchstart' in window || 'onmsgesturechange' in window;
    }

    function handleClickEmail(evt){
      // console.log('handleClickEmail');
      evt.preventDefault();
      var email_field = document.querySelector('.sendlater-email-input-field');
      var email = email_field.value;
      var isValid = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(email);
      if(isValid){
        _email = email;
        requestScheduledLater();
        _el.classList.remove('accept-email');
        _el.classList.add('select-time');
        _lastState = 'select-time';
        document.dispatchEvent(eventSubmitEmail);
      }
    }

    function handleClickTime(evt){
      // console.log('handleClickTime');
      var val = document.querySelector('.time-option-change').value;
      requestScheduledLater(val);
      document.dispatchEvent(eventChangedTime);
    }

    function defaultCallback(response){
      // console.log('defaultCallback');
    }

    function scheduleUpdateTime(){
      // console.log('scheduleUpdateTime');
      var field = document.querySelector('.time-option-change');
      field.classList.remove('updating');
      field.classList.add('updated');
    }


    function requestScheduledLater(val){
      // This does the ajax request
      var length      = val || _defaultTime;
      var posObj      = getTopParagraph();
      var content     = posObj.firstParagraph;
      var elSelector  = _selector;
      var params = {
          'action':'remind_to_read',
          'url' : encodeURIComponent(_url),
          'email' : encodeURIComponent(_email),
          'length' : encodeURIComponent(length),
          'selector' : encodeURIComponent(elSelector),
          'content' : encodeURIComponent(content),
          'selectorIndex' : encodeURIComponent(posObj.indx)
      };
      // console.log(params);
      jQuery.ajax({
          url: '/wp-admin/admin-ajax.php',
          data: params,
          success:function(data) {
              // This outputs the result of the ajax request
              // console.log(data);
              defaultCallback(data.responseText);
          },
          error: function(errorThrown){
              // console.log(errorThrown);
          }
      });
    }

    function preventSendLaterSubmitForm(evt){
      // console.log('preventSendLaterSubmitForm');
      evt.preventDefault();
      return false;
    }

    function closeModal(){
      // console.log('closeModal');
      document.dispatchEvent(eventClosed);
      document.querySelector('.sendlater-move-right').classList.add('sendlater-closed');
    }

  }

  TNY.SLApp = SLApp;
})(jQuery, document);

jQuery(document).ready(function(){
  if(jQuery('.sendlater-move-right').length > 0){
    TNY.SLApp();
  }
});
