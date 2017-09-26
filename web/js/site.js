var page;
if ($('.inner-page').length)
    page = 'inner';
else
    page = 'index';

(function () {
    if (page == 'index') {
        var sMessage = $('#sMessage');
        if (sMessage) {
            sMessage.modal('show');
        }

        // contacts
        $('#contactButMap').on('click', '', function (e) {
            $('#form').hide();
            $('#contactsSec').find('.bg').removeClass('bgdark');
            return false;
        });

        $('#contactBut').on('click', '', function (e) {
            $('#form').show();
            $('#contactsSec').find('.bg').addClass('bgdark');
            $("html, body").animate({scrollTop: $('#contactsSec').offset().top + "px"})
            return false;
        });


        if (window.location.hash == '#reg-hackathon') {
            $("#reg-modal").modal('show');
            var stateParameters = {url: ''};
            history.pushState(stateParameters, "", "/"); // меняем адрес
        }
        if (window.location.hash == '#reg-democamp') {
            $("#reg-modal2").modal('show');
            var stateParameters = {url: ''};
            history.pushState(stateParameters, "", "/"); // меняем адрес
        }

        // MAP -------------
        var _initialize = function () {
            var styles = [];
            var myLatlng = new google.maps.LatLng(55.742305, 37.609524)
            var map_canvas = document.getElementById('map');
            var map_options = {
                streetViewControl: false,
                scrollwheel: false,
                center: myLatlng,
                zoom: 16,
                minZoom: 12,
                maxZoom: 18,
                disableDefaultUI: false,
                draggable: false,
                apTypeControlOptions: {
                    mapTypeIds: ['Styled']
                },
                mapTypeId: 'Styled'
            }

            var map = new google.maps.Map(map_canvas, map_options)
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: "БЦ «SkyLight»",
                maxWidth: 200,
                maxHeight: 200
            });
            var styledMapType = new google.maps.StyledMapType(styles, {name: 'Styled'});
            map.mapTypes.set('Styled', styledMapType);
        };
        google.maps.event.addDomListener(window, 'load', _initialize);
    }

})();

//contacts
(function () {

    if (page == 'inner') {

        /*
         * show/hide panel
         */
        $('.plus-open').each(function (indx, element) {
            var showEl = '.' + element.id;
            $(this).click(function () {
                $("html, body").animate({scrollTop: $('#' + element.id).offset().top + "px"})
                $(showEl).toggle();
                $(this).toggleClass("glyphicon-minus");
            });
        });


    }

})();

(function ($, window, undefined) {
    'use strict';

    if (page == 'inner') {
        window.hackathon = {
            /**
             * portfolio page
             * ==============
             */
            portfolio: {
                /**
                 * link selector
                 */
                link: function () {
                    // @private
                    var _field = $('[name="Profile[portfolio_links]"]');
                    var _addField = $('[name="link"]');

                    var _validateUrl = function (url) {
                        return url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
                    };

                    // @public
                    return {
                        add: function () {
                            var url = _addField.val();

                            // validate url
                            if (!_validateUrl(url)) {
                                alert('Ссылка введена неправильно');
                                return false;
                            }

                            // array of links
                            var links = _field.val().split(" ");

                            // duplicates are not allowed
                            var index = links.indexOf(url);
                            if (index > -1) {
                                return false;
                            }

                            // add url
                            links.push(url);

                            // add html
                            $('.portfolio_links-list').append('<li><a target="_blank" href="' + url + '">' + url + '</a></li>');

                            // reduce array into string and update value
                            _field.val(links.join(" "));
                            _addField.val('');
                        },
                        remove: function (event, url) {
                            event = event || window.event;
                            var target = $(event.target).parent();
                            //var clickedElem = event.target || event.srcElement;
                            //var li = clickedElem.parentNode.innerHTML;                        

                            // array of links
                            var links = _field.val().split(" ");

                            // remove url
                            var index = links.indexOf(url);
                            if (index > -1) {
                                links.splice(index, 1);
                            }

                            _field.val(links.join(" "));
                            target.remove();
                        }
                    };
                }()
            }

        };
    }
})(jQuery, window);