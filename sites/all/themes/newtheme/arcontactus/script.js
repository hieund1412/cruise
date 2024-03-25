var arCuMessages = ["", ""];
var arCuLoop = false;
var arCuCloseLastMessage = false;
var arCuPromptClosed = false;
var _arCuTimeOut = null;
var arCuDelayFirst = 2000;
var arCuTypingTime = 2000;
var arCuMessageTime = 4000;
var arCuClosedCookie = 0;
var arcItems = [];
window.addEventListener('load', function() {
    arCuClosedCookie = arCuGetCookie('arcu-closed');
    jQuery('#arcontactus').on('arcontactus.init', function() {
        if (arCuClosedCookie) {
            return false;
        }
        arCuShowMessages();
    });

    jQuery('#arcontactus').on('arcontactus.openMenu', function() {
        clearTimeout(_arCuTimeOut);
        arCuPromptClosed = true;
        jQuery('#contact').contactUs('hidePrompt');
        arCuCreateCookie('arcu-closed', 1, 30);
    });
    jQuery('#arcontactus').on('arcontactus.hidePrompt', function() {
        clearTimeout(_arCuTimeOut);
        arCuPromptClosed = true;
        arCuCreateCookie('arcu-closed', 1, 30);
    });


    jQuery('#arcontactus2').on('arcontactus.init', function() {
        if (arCuClosedCookie) {
            return false;
        }
        arCuShowMessages();
    });

    jQuery('#arcontactus2').on('arcontactus.openMenu', function() {
        clearTimeout(_arCuTimeOut);
        arCuPromptClosed = true;
        jQuery('#contact').contactUs('hidePrompt');
        arCuCreateCookie('arcu-closed', 1, 30);
    });
    jQuery('#arcontactus2').on('arcontactus.hidePrompt', function() {
        clearTimeout(_arCuTimeOut);
        arCuPromptClosed = true;
        arCuCreateCookie('arcu-closed', 1, 30);
    });


    var lang = $('#lang').val();

    var field_contact_fb_messenger = $('#contact_fb_messenger').val();
    if(field_contact_fb_messenger != '') {
        var arcItem = {};
        arcItem.id = 'msg-item-1';
        arcItem.class = 'msg-item-facebook-messenger';
        arcItem.title = 'Messenger';
        arcItem.icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224 32C15.9 32-77.5 278 84.6 400.6V480l75.7-42c142.2 39.8 285.4-59.9 285.4-198.7C445.8 124.8 346.5 32 224 32zm23.4 278.1L190 250.5 79.6 311.6l121.1-128.5 57.4 59.6 110.4-61.1-121.1 128.5z"></path></svg>';
        arcItem.href = 'https://m.me/' + field_contact_fb_messenger;
        arcItem.color = '#567AFF';
        arcItems.push(arcItem);
    }

    var field_contact_whatsapp = $('#field_contact_whatsapp').val();
    if(field_contact_whatsapp != '') {
        var arcItem = {};
        arcItem.id = 'msg-item-9';
        arcItem.class = 'msg-item-telegram-plane';
        arcItem.title = 'Whatsapp';
        arcItem.icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg>';
        arcItem.href = 'https://wa.me/' + field_contact_whatsapp ;
        arcItem.color = '#1EBEA5';
        arcItems.push(arcItem);
    }




    // var arcItem = {};
    // arcItem.id = 'msg-item-6';
    // arcItem.class = 'msg-item-skype';
    // arcItem.title = 'Skype Chat';
    // arcItem.icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M424.7 299.8c2.9-14 4.7-28.9 4.7-43.8 0-113.5-91.9-205.3-205.3-205.3-14.9 0-29.7 1.7-43.8 4.7C161.3 40.7 137.7 32 112 32 50.2 32 0 82.2 0 144c0 25.7 8.7 49.3 23.3 68.2-2.9 14-4.7 28.9-4.7 43.8 0 113.5 91.9 205.3 205.3 205.3 14.9 0 29.7-1.7 43.8-4.7 19 14.6 42.6 23.3 68.2 23.3 61.8 0 112-50.2 112-112 .1-25.6-8.6-49.2-23.2-68.1zm-194.6 91.5c-65.6 0-120.5-29.2-120.5-65 0-16 9-30.6 29.5-30.6 31.2 0 34.1 44.9 88.1 44.9 25.7 0 42.3-11.4 42.3-26.3 0-18.7-16-21.6-42-28-62.5-15.4-117.8-22-117.8-87.2 0-59.2 58.6-81.1 109.1-81.1 55.1 0 110.8 21.9 110.8 55.4 0 16.9-11.4 31.8-30.3 31.8-28.3 0-29.2-33.5-75-33.5-25.7 0-42 7-42 22.5 0 19.8 20.8 21.8 69.1 33 41.4 9.3 90.7 26.8 90.7 77.6 0 59.1-57.1 86.5-112 86.5z"></path></svg>';
    // arcItem.href = 'skype://hoangdacviet?chat';
    // arcItem.color = '#1C9CC5';
    // arcItems.push(arcItem);

    //Email
    if($('#field_site_email').val() != '') {
        var email_title
        if(lang == 'en') {
            email_title = 'Email';
        } else {
            email_title = 'Thư điện tử';
        }
        var arcItem = {};
        arcItem.id = 'msg-item-7';
        arcItem.class = 'msg-item-envelope';

        arcItem.title = email_title;
        arcItem.icon = '<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M464 64H48C21.5 64 0 85.5 0 112v288c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM48 96h416c8.8 0 16 7.2 16 16v41.4c-21.9 18.5-53.2 44-150.6 121.3-16.9 13.4-50.2 45.7-73.4 45.3-23.2.4-56.6-31.9-73.4-45.3C85.2 197.4 53.9 171.9 32 153.4V112c0-8.8 7.2-16 16-16zm416 320H48c-8.8 0-16-7.2-16-16V195c22.8 18.7 58.8 47.6 130.7 104.7 20.5 16.4 56.7 52.5 93.3 52.3 36.4.3 72.3-35.5 93.3-52.3 71.9-57.1 107.9-86 130.7-104.7v205c0 8.8-7.2 16-16 16z"></path></svg>';
        arcItem.href = 'mailto:' + $('#field_site_email').val();
        arcItem.color = '#FF643A';
        arcItems.push(arcItem);
    }


    //Goi dien thoai
    if($('#field_site_phone').val() != '') {
        var phone_title = '';
        if(lang == 'en') {
            phone_title = 'Call ' + $('#field_site_phone').val();
        } else {
            phone_title = 'Gọi số ' + $('#field_site_phone').val();
        }
        var arcItem = {};
        arcItem.id = 'msg-item-8';
        arcItem.class = 'msg-item-phone';
        arcItem.title = phone_title;
        arcItem.icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"></path></svg>';
        arcItem.href = 'tel:' + $('#field_site_phone').val();
        arcItem.color = '#4EB625';
        arcItems.push(arcItem);
    }

    jQuery('#arcontactus').contactUs({
        items: arcItems
    });
    jQuery('#arcontactus2').contactUs({
        items: arcItems
    });
});