import './bootstrap';
import './lib/jsshare'

import Alpine from 'alpinejs';
import 'flowbite';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function(event) {
    var shareItems = document.querySelectorAll('.social_share');
    var isIOS = /iPad|iPhone|iPod/.test(navigator.platform)
      || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
    var isAndroid = /(android)/i.test(navigator.userAgent);
    var options = {};
    if (isIOS || isAndroid) {
      options.link_telegram = 'tg://msg';
      options.link_whatsapp = 'whatsapp://send';
    }
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('social_share'))
        {
            return JSShare.go(e.target, options);
        }
    })
    
  });
