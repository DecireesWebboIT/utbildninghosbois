/* Custom Menu Wizard plugin
 * Script for controlling this widget's options (in Admin -> Widgets)
 * NB : in some functions a seemingly unnecessary var declaration has been used in order
 * to avoid Google Close Compiler producing a "Misplaced function annotation" warning!
*/
/*global jQuery, window, document, ajaxurl */
/*jslint browser: true, for: true, multivar: true, this: true, white: true */
/*jshint curly: true, eqeqeq: true, forin: true, freeze: true, futurehostile: true, latedef: true, noarg: true, nocomma: true, nonbsp: true, nonew: true, strict: true, undef: true, laxbreak: true */
jQuery(function($){
  'use strict';
  var cmwAssist,
      //only test for : key="value", key='value' and key=value...
      parseSwitchTo = /(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)/g,

      getText = function(t){
        return !window.Custom_Menu_Wizard_Texts ? t : window.Custom_Menu_Wizard_Texts[t] || t;
      },

      isNumeric = function(x){
        return (/^[+\-]?\d+$/).test(x.toString());
      },

      widgetCustomMenuWizardClass = function(suffix, dot){
        return (!dot ? '' : '.') + 'widget-custom-menu-wizard-' + suffix;
      },

      assistance = function(e){
        /**
         * updates the graphic menu structure from the widget settings
         * @this {element} div.widget-custom-menu-wizard-onchange
         * @param {object} e Event object
         */
        var v = $(this).data().cmwInstanceVersion.replace(/\./g, '');
        v = /^\d+$/.test(v) ? 'v' + v : v;
        //run the update() method of the relevant assist object, based on a version number...
        if(cmwAssist[v]){
          cmwAssist[v].update(e ? e.target : this);
        }else{
          cmwAssist.update(e ? e.target : this);
        }
      }, //end assistance()

      getSettings = function(oc, altFields){
        /**
         * gets the widget's field values, or their equivalents from an alternative set
         * @param {object|boolean} oc jQuery of the widget's onchange wrapper (false if altFields are supplied)
         * @param {object} altFields Optional parsed set of alternative field settings
         * @return {object} key=>value pairs of the field element values
         */
        var useAlternative = oc === false,
            settings = {},
            legacyVersion = !useAlternative && oc.data().cmwInstanceVersion === '2.1.0',
            csv = {items:1, exclude:1},
            keepAsString = $.extend({branch_start:1, exclude_level:1, include_level:1}, csv);
        $.each(useAlternative ? altFields : oc.find(':input').serializeArray(), function(ignore, v){
          var name = v.name.replace(/.*\[([^\]]+)\]$/, '$1'),
              val = ( !keepAsString[name] && (/^-?\d+$/).test(v.value) ) ? parseInt(v.value, 10) : v.value;
          settings[name] = val;
          if(csv[name]){
            settings['_' + name + '_sep'] = ( !val || (/(^-?\d+\+?$|,)/).test($.trim(val)) ) ? ',' : ' ';
            val = $.map(val.split(/[,\s]+/), function(x){
              var inherit = !legacyVersion && (/\+$/).test(x);
              x = x ? parseInt(x, 10) : 0;
              return ( isNaN(x) || !x ) ? null : (inherit ? x + '+' : x);
            });
            settings['_' + name] = val.join(settings['_' + name + '_sep']);
          }
        });
        return settings;
      }, //end getSettings()

      alternativeCheckFor = function(at, hasCurrent, itemsLength, settings){
        /**
         * checks for switching to the alternative settings (v3.1.0)
         * @param {string} at Processing stage
         * @param {boolean} hasCurrent Current Item is in items
         * @param {integer} itemsLength Items length
         * @param {array} settings Current settings
         * @return {boolean} True if should switch to alternative settings
         */
        var switchIf = settings.switch_if;
        return (settings.switch_at === at && (
            ( switchIf === 'current' && hasCurrent ) ||
            ( switchIf === 'no-current' && !hasCurrent ) ||
            ( switchIf === 'no-output' && !itemsLength )
            ) );
      }, //end alternativeCheckFor()

      alternativeParse = function(switchTo, themenu){
        /**
         * takes a switch_to setting, parses it, and returns settings (equiv. Custom_Menu_Wizard_Plugin->shortcode_instance())
         * @param {string} switchTo switch_to value
         * @param {object} themenu jQuery of demo menu structure (.cmw-demo-themenu-ul)
         * @return {object} Settings, or False if can't be determined
         */
        switchTo = $.trim(switchTo || '');
        var alts = {
              'title'             : '',
              'level'             : 1, //default setting
              'branch'            : 0,
              'items'             : '',
              'depth'             : 0,
              'depth_rel_current' : 0,
              'start_at'          : '',
              'start_mode'        : '',
              'allow_all_root'    : 0,
              'ancestors'         : 0,
              'ancestor_siblings' : 0,
              'include_root'      : 0,
              'include_level'     : '',
              'siblings'          : 0,
              'exclude'           : '',
              'exclude_level'     : '',
              'contains_current'  : '',
              'fallback'          : '',
              'flat_output'       : 0,
              'title_from'        : '',
              'title_linked'      : 0,
              'ol_root'           : 0,
              'ol_sub'            : 0
            },
            attribute = parseSwitchTo.exec(switchTo),
            attr = {},
            i = 0,
            byItems, byBranch, byLevel, n;
        while(attribute){
          i += 1;
          // key = "value" [1] [2] ...
          if(attribute[1]){
            attr[ attribute[1] ] = attribute[2];
          // key = 'value' [3] [4] ...
          }else if(attribute[3]){
            attr[ attribute[3] ] = attribute[4];
          // key = value   [5] [6] ...
          }else if(attribute[5]){
            attr[ attribute[5] ] = attribute[6];
          }else{
            i -= 1;
          }
          attribute = parseSwitchTo.exec(switchTo);
        }
        if(i){
          $.each(attr, function(k, v){
            alts[k] = v;
          });
        }

        //in order of priority...
        byItems = !!alts.items;
        byBranch = !byItems && !!alts.branch;
        byLevel = !byItems && !byBranch;

        if(byItems){
          alts.filter = 'items';
        }
        if(byBranch){
          alts.filter = 'branch';
          n = alts.start_at.toString();
          //default...
          alts.branch_start = n;
          //override...
          if(n === '0' || n === 'branch'){
            alts.branch_start = '';
          }
          if(n === 'root'){
            alts.branch_start = '1';
          }
          if(n === 'children'){
            alts.branch_start = '+1';
          }
          if(n === 'parent'){
            alts.branch_start = '-1';
          }
          if(alts.branch === 'current' || alts.branch === 'current-item'){
            alts.branch = 0;
          }else if( !isNumeric( alts.branch ) ){
            //if branch is non-numeric then it could be the title of a menu item, but we need it to be the menu item's id...
            //NB : if branch *is* numeric, but the item id is not within this menu, then ... tough! Basically, this assist mimics what
            //     the widget does, and the widget doesn't check numeric branch values until it gets into the walker - at which point
            //     it either produces the relevant output or doesn't. only if branch is non-numeric and possibly an item title does
            //     the widget pre-check for it being in the menu (because the walker requires an item id) : so this does the same.
            alts.branch = alts.branch.toLowerCase();
            n = themenu.find('a.cmw-item').filter(function(){
              return $(this).text().toLowerCase() === alts.branch;
            });
            if(n.length){
              alts.branch = n.parent().data('itemid');
            }else{
              //COP OUT!
              return false;
            }
          }
        }
        if(byLevel){
          alts.filter = '';
          alts.level = Math.max(1, parseInt(alts.level, 10));
        }
        alts.start_at = null;

        //include_level, and the deprecated include_root switch...
        //if level is empty but root is set, set include_level to '1'...
        if( !alts.include_level && alts.include_root === '1' ){
          alts.include_level = '1';
        }
        alts.include_root = null;
        //fallback => fallback and fallback_siblings and fallback_depth...
        //allows "X", "X,Y" or "X,Y,Z" where comma could be space, and X|Y|Z could be "quit"|"current"|"parent", or "+siblings", or digit(s)
        //but "quit", "current" or "parent" must be present (others are optional)
        if(byBranch && !alts.branch && alts.fallback ){
          attr = alts.fallback.toLowerCase().split(/[\s,]+/);
          n = ' ' + attr.join(' ') + ' ';
          alts.fallback = '';
          if(n.indexOf(' quit ') >= 0){
            alts.fallback = 'quit';
          }else if(n.indexOf(' parent ') >= 0){
            alts.fallback = 'parent';
          }else if(n.indexOf(' current ') >= 0){
            alts.fallback = 'current';
          }
          if(alts.fallback !== '' && alts.fallback !== 'quit'){
            if( n.indexOf(' +siblings ') >= 0){
              alts.fallback_siblings = 1;
            }
            for(i = 0; i < attr.length; i += 1){
              if(/^\d+$/.test(attr[i])){
                n = parseInt(attr[i], 10);
                if(n > 0){
                  alts.fallback_depth = n;
                  break;
                }
              }
            }
          }
        }
        //title_from => title_...
        if(alts.title_from){
          attr = alts.title_from.toLowerCase().split(/[\s,]+/);
          for(i = 0; i < attr.length; i += 1){
            if(attr[i]){
              if(attr[i] === 'branch' || attr[i] === 'current'){
                alts['title_' + attr[i]] = '0';
              }else{
                n = attr[i].match(/^(branch|current)(-root|-parent|[+\-]?\d+)$/);
                if(n){
                  if(n[2] === '-root'){
                    alts['title_' + n[1]] = 1;
                  }else if(n[2] === '-parent'){
                    alts['title_' + n[1]] = -1;
                  }else{
                    alts['title_' + n[1]] = n[2];
                    if(!alts['title_' + n[1]]){
                      alts['title_' + n[1]] = '';
                    }
                  }
                }
              }
            }
          }
        }
        alts.title_from = null;

        return getSettings( false, $.map(alts, function(v, k){ return v === null ? v : {name:k, value:v}; }) );
      }, //end alternativeParse()

      alternativeStripDown = function(x){
        /**
         * strips an alternative settings shortcode down to its bare essentials (v3.1.0)
         * @param {string} x The alternative
         * @return {string}
         */
        var rtn = '';
        if(!!x){
          //remove tabs, CRLFs, containing square brackets, self-terminator and spaces, then split on square bracket, taking first element...
          rtn = x.replace(/[\r\n\t]+/g, ' ').replace(/^[\[\s]+/, '').replace(/[\s\/\]]+$/, '').split(/[\[\]]/)[0];
          //trim trailing slash, surrounding spaces, and append a space...
          rtn = $.trim(rtn.replace(/\/+$/, '')) + ' ';
          //remove leading cmwizard, any occurrence of menu|widget=something, and any occurrence of alternative="something" (optional quotes)...
          rtn = ' ' + rtn.replace(/^cmwizard\s/, '') + ' ';
          rtn = $.trim( rtn.replace(/\s(menu|widget)=[^\s]*/g, ' ').replace(/\salternative=("[^"]*"|[^\s]*)/g, ' ') );
          //remove multiple spaces...
          rtn = rtn.replace(/\s\s+/g, ' ');
        }
        return rtn;
      },
      alternativeUse = function(settings, dialog){
        /**
         * retrieves alternative settings
         * @param {array} settings Current settings
         * @param {object} dialog jQuery of dialog
         * @return {boolean|array} Alternative settings
         */
        //alt settings are cached in the data of the menu display (which gets reconstructed when menu id changes)
        var themenu = dialog.find('.cmw-demo-themenu-ul'),
            dataStore = themenu.data(),
            altCode = alternativeStripDown( settings.switch_to );
        altCode = 'cmwizard menu=' + settings.menu + (altCode === '' ? altCode : ' ' + altCode);

        //if don't have cached code, or the code has changed, get new set...
        if(!dataStore.altCode || dataStore.altCode !== altCode){
          dataStore.altCode = altCode;
          dataStore.altSettings = alternativeParse(altCode, themenu);
        }
        //show that we are - or should be - using the alternative settings...
        dialog.find('.cmw-demo-alternative').addClass('updated')
          //...but if they're bad settings (from a bad switch_to code?) then show as an error...
          .toggleClass('error', dataStore.altSettings === false);

        return dataStore.altSettings === false ? false : $.extend({}, dataStore.altSettings);
      }, //end alternativeUse()

      filterTickCross = function( items, settings, tickOrCross ){
        /**
         * sets the tick or cross classes and returns a filtered set of the items that *are* ticked/crossed
         * @param {object} items jQuery of elements to filter
         * @param {array} settings Widget settings
         * @param {string} tickOrCross Either 'tick' or 'cross'
         * @return {object} jQuery of filtered items
         */
        var sep = tickOrCross === 'tick' ? '_items_sep' : '_exclude_sep',
            inheritance = [],
            haystack = tickOrCross === 'tick' ? '_items' : '_exclude';
        sep = settings[sep];
        haystack = settings[haystack]
          //extract those with inheritance...
          ? $.grep(settings[haystack].split(sep), function(v){
              if(/\+$/.test(v)){
                inheritance.push(parseInt(v, 10));
                return !v;
              }
              return !!v;
            })
          : [];
        haystack = sep + haystack.join(sep) + sep;
        inheritance = sep + inheritance.join(sep) + sep;
        //need to remember that we're turning off as well as on, because there's no generic clear-down...
        items = items.each(function(){
            var item = $(this),
                data = item.data(),
                inherit = inheritance.indexOf(sep + data.itemid + sep) > -1,
                matched = inherit || haystack.indexOf(sep + data.itemid + sep) > -1;
            item.toggleClass('cmw-has-' + tickOrCross, matched)
              .toggleClass('cmw-inherit-' + tickOrCross, inherit);
          });
        //returning items that *are* ticked/crossed, so get the inheritance items...
        return items.filter('.cmw-inherit-' + tickOrCross)
          //...get their descendants and clear any tick/cross classes that may have been set...
          .find('li').removeClass('cmw-has-' + tickOrCross + ' cmw-inherit-' + tickOrCross)
          //...add back in (to the inheritance descendants) any (other) items that still have tick/cross
          //set, which will include the uppermost of any inheritance items...
          .add( items.filter('.cmw-has-' + tickOrCross) );
      }, //end filterTickCross

      findOnchange = function(el, below){
        /**
         * gets the -onchange wrapper
         * @param {object} el jQuery of element to search above (default) or below
         * @param {integer} below Indicates whether to search below (exclusive, ie. find()) or above (inclusive, ie. closest())
         * @return {object} jQuery of the -onchange wrapper
         */
        var f = !below ? 'closest' : 'find';
        return el[f](widgetCustomMenuWizardClass('onchange', 1));
      },

      getLevelClasses = function(option, maxLevel){
        /**
         * given an option in the form of one-or-more digits, optionally followed by a plus or minus, return the relevant classes
         * @param {string} option A setting, eg. settings.exclude_level
         * @param {integer} maxLevel Maximum number of levels available
         * @return {string} CSV of classes, eg. '.level-1,'level-2' for option='2-' (or option='1+' if maxLevel=2)
         */
        var rtn = [],
            k = option.match(/^(\d+)(\+|-)?$/),
            i;
        k = k ? [parseInt(k[1], 10), k[2] || ''] : [];
        if(k[0] > 0){
          for(i = 1; i <= maxLevel; i += 1){
            if( i === k[0] || (k[1] === '-' && i < k[0]) || (k[1] === '+' && i > k[0]) ){
              rtn.push('.level-' + i);
            }
          }
        }
        return rtn.join(',');
      },

      showOutput = function(dialog, settings){
        /**
         * produces the final output
         * @param {object} dialog jQuery of target dialog
         * @param {object} settings Field element values
         */
        var topOfMenu = dialog.find('.cmw-demo-themenu-ul'),
            items = topOfMenu.find('.picked'),
            html = '',
            title = settings.hide_title ? '' : settings.title,
            titleLinked = 0,
            currLevel = 0,
            output = dialog.find('.cmw-demo-theoutput-wrap').empty(),
            listClass = ['menu-widget'],
            itemList = {};
        if(items.length && output.length){
          //determine title: update() might have set a class for it...
          title = topOfMenu.find('.title-from-item').children('.cmw-item').find('strong').text() || '';
          titleLinked = !!title && !!settings.title_linked;
          //...otherwise, check the actual widget title...
          if(!title && !settings.hide_title){
            title = settings.title || '';
          }

          items.each(function(i){
            var self = $(this),
                data = self.data(),
                trace = data.trace ? data.trace.toString().split(',') : [],
                iid = data.itemid.toString(),
                level = 1,
                anchor = self.children('.cmw-item');
            if(!settings.flat_output){
              itemList[iid] = 1;
              for(i = 0; i < trace.length; i += 1){
                if(itemList[trace[i]]){
                  level += 1;
                }
              }
            }
            if(currLevel){
              if(level > currLevel){
                html += settings.ol_sub ? '<ol>' : '<ul>';
              }else{
                while(currLevel > level){
                  currLevel -= 1;
                  html += '</li>' + (settings.ol_sub ? '</ol>' : '</ul>');
                }
                html += '</li>';
              }
            }
            html += '<li class="cmw-level-' + level + (data.included || '') + '"><a href="#' + anchor.data('indx') + '">' + anchor.find('strong').text() + '</a>';
            currLevel = level;
          });
          while(currLevel > 1){
            currLevel -= 1;
            html += '</li>' + (settings.ol_sub ? '</ol>' : '</ul>');
          }
          html += '</li>';
          listClass.push( dialog.find('.cmw-demo-fallback').data('fellback') );
          html = (settings.ol_root ? '<ol' : '<ul') + ' class="' + $.trim(listClass.join(' ')) + '">' + html + (settings.ol_root ? '</ol>' : '</ul>');
          output.html(html);
          output.find('li').filter(function(){
            return !!$(this).children('ul, ol').length;
          }).addClass('cmw-has-submenu');
        }
        if(output.length && title && items.length){
          output.prepend((titleLinked ? '<h3 class="cmw-title-linked">' : '<h3>') + title + '</h3>');
        }
      }, //end showOutput()

      swapItems = function(menuItems, selectedItem, selectedMenu){
        /**
         * swap in the apropriate optgroup of items according to the selected menu
         * @param {object} menuItems jQuery of the SELECT being modified
         * @param {integer} selectedItem Currently selected item in menuItems
         * @param {integer} selectedMenu Index of selected menu
         * @return {integer} selectedItem
         */
        var groupClone;
        if(!menuItems.find('optgroup').filter(function(){
              var keepit = $(this).data().cmwOptgroupIndex === selectedMenu;
              if(!keepit){
                $(this).remove();
              }
              return keepit;
            }).length){
          groupClone = $('#' + menuItems.attr('id') + '_ignore').find('optgroup').eq(selectedMenu).clone();
          if(groupClone.length){
            if(selectedItem > 0){
              selectedItem = 0;
            }
            menuItems.append(groupClone).val(selectedItem);
          }
        }
        return selectedItem;
      }, //end swapItems()

      clickFieldset = function(ignore){
        /**
         * toggles a set of widgets options open or closed
         * @this {element} Header of the set
         * @param {object} e Event object
         * @return {boolean} false
         */
        var self = $(this),
            chkbox = self.next('.cmw-fieldset-state'),
            collapse = !chkbox.prop('checked');
        if(chkbox.length){
          chkbox.prop('checked', collapse);
          self.toggleClass('cmw-collapsed-fieldset', collapse);
          chkbox.next('div')[collapse ? 'slideUp' : 'slideDown']('fast');
        }
        this.blur();
        return false;
      }, //end clickFieldSet()

      clickFindShortcodes = function(ignore){
        /**
         * fetches and displays a list of posts that contain old/new shortcodes
         * @this {element} The link/button
         * @param {object} e Event object
         * @return {boolean} false
         */
        var self = $(this),
            grandad = self.parent().parent();
        //if currently fetching, do nothing...
        if(ajaxurl && !grandad.hasClass('cmw-ajax-fetching')){
          //if currently showing previous results, remove the results from view...
          if(grandad.hasClass('cmw-ajax-showing')){
            grandad.removeClass('cmw-ajax-showing');
          }else{
            //fetch results via ajax, showing spinner while doing so...
            grandad.addClass('cmw-ajax-fetching');
            $.get(
              ajaxurl,
              { 'action': 'cmw-find-shortcodes', '_wpnonce': self.data().nonce }
            ).done(function(response){
                if(!!response && response !== '0'){
                  grandad.find('.cmw-demo-found-shortcodes').html($(response).find('response_data').text());
                  grandad.addClass('cmw-ajax-showing');
                }
              }
            ).always(function(/*response*/){
                grandad.removeClass('cmw-ajax-fetching');
              }
            );
          }
        }
        this.blur();
        return false;
      },

      clickFixedAbsolute = function(ignore){
        /**
         * toggles fixed/absolute positioning for the dialog (work around for draggable problems in jQuery UI v1.10.3/4)
         * @this {element} The "fixed" button
         * @param {object} e Event object
         * @return {boolean} false
         */
        var self = $(this),
            data = self.data(),
            toAbsolute = !data.cmwAbsolute,
            dialogBox = self.closest('.ui-dialog'),
            dialog = dialogBox.find('.ui-dialog-content'),
            //if fixed -> absolute, add scrollTop to [css]top; if absolute -> fixed, substract scrollTop from [css]top...
            newTop = parseInt(dialogBox.css('top'), 10) + ( (toAbsolute ? 1 : -1) * $(document).scrollTop() );
        data.cmwAbsolute = toAbsolute;
        if(!data.cmwMaxHeight){
          //store the initial maxHeight setting...
          data.cmwMaxHeight = dialog.dialog('option', 'maxHeight');
        }
        //swap the icon...
        self.children('span').toggleClass('dashicons-no-alt', toAbsolute);
        //toggle the class to force either fixed (add class) or absolute (remove class)...
        dialogBox.toggleClass('cmw-assistance-dialog-fixed', !toAbsolute);
        //have to reset dialog's maxHeight here, *before* re-positioning, because UI will screw up the position when we set it!...
        dialog.dialog('option', {maxHeight: toAbsolute ? !toAbsolute : data.cmwMaxHeight});
        //re-position the dialog (have to use CSS because UI dialog's position option doesn't hack it!)...
        dialogBox.css('top', newTop);
        return false;
      },

      clickItemExtras = function(ignore){
        /**
         * click handler for toggling more/less item display
         */
        $(this).closest('.widget-custom-menu-wizard-dialog').toggleClass('cmw-show-item-extras');
        this.blur();
        return false;
      },

      clickMenu = function(ignore){
        /**
         * click handler for an item in the menu structure : sets or clears current menu item and its ancestors
         * @this {element} Anchor element clicked on
         * @param {object} e Event object
         * @return {boolean} false
         */
        var self = $(this),
            cls = ['current-menu-item', 'current-menu-parent', 'current-menu-ancestor'],
            dialog = self.closest('.ui-dialog-content'),
            topOfMenu = dialog.find('.cmw-demo-themenu-ul'),
            inPath = self.find('span').not('.' + cls[0]).parentsUntil(topOfMenu, 'li'),
            i, n,
            appendCls = function(){
              this.title = this.title + ' : ' + n.replace(' ', ' & ').replace(/-/g, ' ');
            };
        topOfMenu.find('.' + cls.join(',.')).removeClass(cls.join(' ')).each(function(){
          this.title = this.title.replace(/\s:\s.*$/, '');
        });
        for(i = 0; i < inPath.length; i += 1){
          n = i === 1 ? cls.join(' ') : cls[0];
          inPath.eq(i).children('.cmw-item').find('span').addClass(n).each(appendCls);
          if(cls.length > 1){
            cls.shift();
          }
        }
        //run update() via assistance()...
        assistance.call( $(dialog.data().cmwOnchange).get(0) );
        this.blur();
        return false;
      }, //end clickMenu()

      clickOutput = function(ignore){
        /**
         * click handler for an item in the Basic Output list : triggers a click on the respective menu structure item
         * @this {element} Anchor element clicked on
         * @param {object} e Event object
         * @return {boolean} false
         */
        var rtn = false;
        $(this).closest('.ui-dialog-content').find('.cmw-item')
          .eq( this.href.split('#')[1] )
          .not(':has(.current-menu-item)').trigger('click');
        this.blur();
        return rtn;
      }, //end clickOutput()

      clickTreeExpander = function(ignore){
        /**
         * click handler for assist's menu tree expander/collapser
         * @this {element} Element clicked on
         * @param {object} e Event object
         * @return {boolean} false
         */
        var direction = /w-r/.test(this.className) ? 'slideUp' : 'slideDown';
        $(this).toggleClass('dashicons-arrow-right dashicons-arrow-down').prev('ul')[direction]('fast');
        this.blur();
        return false;
      },

      clickTickCross = function(ignore){
        /**
         * click handler for a tick or cross against any item in the menu structure (does not modify any classes)
         * @this {element} Tick or Cross clicked on
         * @param {object} e Event object
         * @return {boolean} false
         */
        var self = $(this),
            tickOrCross = self.hasClass('cmw-tick') ? 'tick' : 'cross',
            item = self.parent(),
            topOfMenu = item.closest('.cmw-demo-themenu-ul'),
            hasInheritTickCross = item.hasClass('cmw-inherit-' + tickOrCross),
            hasTickCross = hasInheritTickCross || item.hasClass('cmw-has-' + tickOrCross),
            inheritsTickCrossFrom = hasTickCross ? $([]) : item.parentsUntil(topOfMenu, '.cmw-inherit-' + tickOrCross),
            widgetField = $( item.closest('.ui-dialog-content').data().cmwOnchange )
              .find(tickOrCross === 'tick' ? '.cmw-setitems' : '.cmw-exclusions'),
            sampleSet;
        //if we're using the alternative settings, then click a tick/cross is disabled because they are set according to the
        //alternative settings, which are not modifiable via this instance of the assist!
        if(!topOfMenu.hasClass('cmw-using-alternative') && widgetField.length){ //should never not find it!
          //A. if this item hasInheritTickCross then this click will remove tickCross entirely and all inheritance will be lost
          //B. else* if this item hasTickCross then this click will either
          //   B1. if the item has no descendants, or we're running legacy version, remove the tickCross
          //   B2. else add inheritance to it
          //C. else* if this item inheritsTickCross then this click will
          //   - disinherit the relevant ancestor (keeping tickCross!)
          //   - and set all its descendants - bar this* item! - to tickCross
          //D. else* this click will add tickCross (without inheritance) to this item

          //find everything that currently has tickCross, and for (A) remove this item, or for (D) add this item...
          //note : for (B) this item is already included, and for (C) this item is not already included and we don't want it to be
          sampleSet = topOfMenu
            .find('.cmw-has-' + tickOrCross)[ ( hasInheritTickCross || inheritsTickCrossFrom.length ) ? 'not' : 'add' ](item);
          //(A) & (D) are now sorted and can be forgotten about
          //for (B1), remove this item...
          if(hasTickCross && (!item.children('ul').length || topOfMenu.parent().hasClass('cmw-version-210'))){
            sampleSet = sampleSet.not(item);
          }
          else
          //for (B2), because we're adding inheritance, any descendant of this item that is currently tickCross now needs to be excluded...
          if(hasTickCross && !hasInheritTickCross){
            sampleSet = sampleSet.not( item.find('.cmw-has-' + tickOrCross) );
          }
          //(B) is now also sorted and can be forgotten about
          //for (C) we need to find the ancestor providing the inheritance and add in all its descendants bar this item...
          sampleSet = sampleSet.add( inheritsTickCrossFrom.find('li').not(item) );
          //map what's left to the associated item id, appending a plus sign for inheritance...
          sampleSet = sampleSet.map(function(){
              var plus = ( this === item[0] || this === inheritsTickCrossFrom.get(0) ) ? hasTickCross : $(this).hasClass('cmw-inherit-' + tickOrCross);
              return $(this).data().itemid + (plus ? '+' : '');
            })
            .get().join( /(,|^-?\d+\+?$)/.test( $.trim(widgetField.val()) || ',' ) ? ',' : ' ' );
          widgetField.val(sampleSet).trigger('change');
        }
        this.blur();
        return false;
      }, //end clickTickCross()

      closeDialog = function(ignore){
        /**
         * closes an open dialog when the widget is closed
         * @this {element} The .widget-action or .widget-control-close clicked on
         * @param {object} e Event object
         */
        var widgetContainer = $(this).closest('div.widget'),
            containerParent = widgetContainer.parent();
        //in widget customizer, opening one widget closes any other open widget without triggering anything that
        //would make CMW close the assist ... which is good! however, I also don't want the assist to close when
        //[re]opening a CMW widget, so for the customizer I need to check that the widget is "expanded" before
        //making the assist close...
        if(!containerParent.hasClass('customize-control-widget_form') || containerParent.hasClass('expanded')){
          findOnchange(widgetContainer, 1).each(function(){
            var dialog = $('#' + $(this).data().cmwDialogId);
            if(dialog.length && dialog.dialog('isOpen')){
              dialog.dialog('close');
            }
          });
        }
      }, //end closeDialog()

      createDialog = function(data){
        /**
         * creates the UI Dialog for the widget's assist
         * @param {object} data Information required to build the dialog
         * @return {object} jQuery object of the created Dialog
         */
        var dialogOpts = {
              autoOpen: false,
              //initial width is the lowest of 600px and 90% of window width...
              width: Math.min($(window).width() * 0.9, 600),
              //starting out at fixed, so max the resizable height at 40px less than window height so that entire dialog box is visible...
              maxHeight: $(window).height() - 40,
              modal: false,
              containment: 'window',
              create: function(){
                //add a "fixed" button to the titlebar, enabling switching between fixed and absolute positioning for the dialog...
                var dialogBox = $(this).closest('.ui-dialog');
                if(dialogBox.hasClass('cmw-assistance-dialog-fixed')){
                  $('<a/>').addClass('cmw-dialog-fixed-absolute button-secondary')
                    .append( $('<span/>').addClass('dashicons-before dashicons-yes').text(getText('fixed')) )
                    .on('click', clickFixedAbsolute)
                    .appendTo( dialogBox.find('.ui-dialog-titlebar') );
                }
              },
              dragStop: function(){
                //set height to auto...
                $(this).dialog('option', 'height', 'auto');
              },
              dialogClass: 'cmw-assistance-dialog cmw-assistance-dialog-fixed'
            },
            msgs = $.map(['setcurrent', 'inclusions', 'exclusions', 'fallback', 'alternative'], function(v){
              return '<div class="cmw-demo-' + v + ' cmw-demo-small">' + getText(v) + '</div>';
            }),
            dialog = $('<div/>', {id:data.cmwDialogId}).addClass(widgetCustomMenuWizardClass('dialog'))
              .append(
                $('<div/>').addClass('cmw-demo-themenu cmw-version-' + data.cmwInstanceVersion.replace(/\./g, ''))
                  .html('<em class="cmw-demo-small">' + getText('prompt') + '</em>')
              )
              .append(
                $('<div/>').addClass('cmw-demo-theoutput cmw-corners')
                  .html('<em class="cmw-demo-small">' + getText('output') + '</em><em class="cmw-demo-plugin-version cmw-demo-small">v' + data.cmwInstanceVersion + '</em>' + msgs.shift() + '<div class="cmw-demo-theoutput-wrap cmw-corners"></div>' + msgs.join(''))
              )
              .append(
                $('<div/>').addClass('cmw-demo-theshortcode')
                  .html('<code class="cmw-corners"></code><a class="button-secondary cmw-toggle-item-extras"><span>' + getText('more') + '</span><span>' + getText('less') + '</span></a><div class="cmw-find-shortcodes"><a href="#" class="button-secondary ' + widgetCustomMenuWizardClass('find-shortcodes') + '" data-nonce="' + (data.cmwDialogNonce || '') + '" title="' + getText('shortcodes') + '"><span class="spinner"></span><span>[&hellip;]</span></a></div><div class="cmw-demo-found-shortcodes cmw-demo-small cmw-corners"></div>')
              );
        dialog.dialog(dialogOpts);
        dialog
          .on('click', '.cmw-toggle-item-extras', clickItemExtras)
          .find('.cmw-demo-themenu')
            .on('click', '.cmw-tick,.cmw-cross', clickTickCross)
            .on('click', '.cmw-item', clickMenu);
        dialog.find('.cmw-demo-theoutput').on('click', 'a', clickOutput);
        return dialog;
      }, //end createDialog()

      removeDialog = function(ignore){
        /**
         * removes associated dialog when the widget is deleted
         * @this {element} The .widget-control-remove clicked on
         * @param {object} e Event object
         */
        var widget = $(this).closest('div.widget');
        findOnchange(widget, 1).each(function(){
          var dialog = $('#' + $(this).data().cmwDialogId);
          if(dialog.length){
            dialog.dialog('destroy');
            dialog.remove();
          }
        });
      }, //end removeDialog()

      setDialogTitle = function(dialog, oc){
        /**
         * (re)sets the dialog's title
         * @param {object} dialog jQuery object of the dialog
         * @param {object} oc jQuery object of the onchange wrapper
         */
        var title = oc.find('.cmw-widget-title').val() || dialog.data().cmwUntitled;
        dialog.dialog('option', 'title', 'CMW : ' + title + ' [' + oc.find('.cmw-select-menu').find('option:selected').text() + ']' );
      }, //end setDialogTitle()

      createMenu = function(dialog){
        /**
         * creates a new list of menu items and inserts it into the dialog content in place of any previous one
         * @param {object} dialog jQuery object of the dialog
         */
        var oc = $(dialog.data().cmwOnchange),
            menuid = parseInt(oc.find('.cmw-select-menu').val(), 10),
            currentmenu = dialog.find('.cmw-demo-themenu-ul'),
            trace = [],
            maxLevel = 0,
            menu = '',
            outdentedExpander = function(x){
              //x is the level of the *previous* item; so if previous item was at level 4, then its parent was at level 3, and
              //was therefore indented twice (given that a level 1 item is not indented), so number of outdents is x - 2!
              //each level is indented by 2.4em; subtract 2 from x and multiply by 2.4em, then add another 2em...
              return x > 1 ? '<a href="#" class="' + widgetCustomMenuWizardClass('colexp') + ' dashicons dashicons-arrow-right" style="left:-' + (((x - 2) * 1.3) + 1.1) + 'em;">&nbsp;</a>' : '';
            };
        if(!currentmenu.length || currentmenu.data('menuid') !== menuid){
          oc.find('.cmw-assist-items optgroup').find('option').each(function(i){
            var self = $(this),
                cmwData = self.data(),
                level = cmwData.cmwLevel,
                itemType = (cmwData.cmwType || '');
            while(level < trace.length){
              menu += '</li></ul>' + outdentedExpander(trace.length);
              trace.pop();
            }
            if(level > trace.length){
              menu += '<ul>';
            }else{
              menu += '</li>';
              trace.pop();
            }
            //data-level is 1-based, with 1 being root
            //data-trace is the menu item ids of this item's ancestors, from root down to parent (inclusive)
            menu += '<li class="level-' + level + '" data-itemid="' + this.value + '" data-level="' + level + '" data-trace="' + trace.join(',') + '">';
            menu += '<a href="#" class="cmw-cross cmw-corners"></a>';
            menu += '<a class="cmw-item cmw-corners" href="#" data-indx="' + i + '"><span class="cmw-corners" title="#' + this.value + ' ' + itemType + '">';
            menu += '<strong>' + $.trim(self.text()) + '</strong>';
            menu += '<i class="cmw-item-extra"><i>' + this.value + '</i>' + itemType + '</i>';
            menu += '</span></a><a href="#" class="cmw-tick cmw-corners"></a>';
            trace.push(this.value);
            if(level > maxLevel){
              maxLevel = level;
            }
          });
          while(trace.length){
            menu += '</li></ul>' + outdentedExpander(trace.length);
            trace.pop();
          }
          currentmenu.remove();
          dialog.find('.cmw-demo-themenu')
            .append( $(menu).addClass('cmw-demo-themenu-ul').data({maxLevel:maxLevel, menuid:menuid}) );
          //set height to auto...
          dialog.dialog('option', 'height', 'auto');
        }
      }, //end createMenu()

      clickAssist = function(ignore){
        /**
         * toggles the assist dialog open/closed, creating it if necessary
         * @this {element} A The assist anchor
         * @param {object} e Event object
         * @return {boolean} false
         */
        var self = $(this),
            oc = findOnchange(self), //above
            data = oc.data(),
            dialog = $( '#' + data.cmwDialogId );
        if(!dialog.length){
          dialog = createDialog(data).data({
            cmwOnchange: '#' + oc.attr('id'),
            cmwUntitled: '[' + getText('untitled') + ']'
            });
        }
        if(dialog.dialog('isOpen')){
          dialog.dialog('close');
        }else{
          createMenu(dialog);
          setDialogTitle(dialog, oc);
          dialog.dialog('open');
          assistance.call(oc[0]);
        }
        this.blur();
        return false;
      }; //end clickAssist()

  /**
   * The assist object, containing functions that do most of the version-specific work.
   * There is a default set of functions, and any different legacy versions that are still
   * supported should be under their own 'vNNN' object (eg. 'v210'). Which set of functions
   * is called is determined by assistance(), which is the only entry point (into update()),
   * and is governed by the widget form (specifically, the cmwInstanceVersion property of
   * the data attached to the -onchange wrapper).
   */
  cmwAssist = {
    setLevels : function(oc, maxLevel){
      /**
       * sets any fields that are dependent on the selected menu
       * @param {object} oc jQuery of the widget's onchange wrapper
       * @param {integer} maxLevel Maximum level of the selected menu
       */
      var theSelect = oc.find('.cmw-branch-start'),
          level = theSelect.val();
      if(!maxLevel){
        return;
      }
      theSelect.find('optgroup').each(function(i){
        var self = $(this),
            opts = self.find('option'),
            ct = opts.length;
        if(i){
          //absolute...
          opts.slice(maxLevel).remove();
          while(ct < maxLevel){
            ct += 1;
            self.append( $('<option/>', {value:ct}).text(ct) );
          }
        }else{
          //relative...
          //if maxLevel is 1 : the item (1 option)
          //if maxLevel is 2 : -1, the item, +1 (3 options)
          //if maxLevel is 3 : -2, -1, the item, +1, +2 (5 options)
          //etc, etc
          ct = (ct + 1) / 2;
          if(ct > maxLevel){
            opts.each(function(ignore, el){
              if(Math.abs(el.value) >= maxLevel){
                $(el).remove();
              }
            });
          }
          while(ct < maxLevel){
            self.prepend( $('<option/>', {value:-ct}).text(-ct + (ct > 1 ? '' : ' (' + getText('parent') + ')')) )
              .append( $('<option/>', {value:'+' + ct}).text('+' + ct + (ct > 1 ? '' : ' (' + getText('children') + ')')) );
            ct += 1;
          }
        }
      });
      //if level is absolute and > maxLevel, set to 1...
      if(/^\d+$/.test(level)){
        if(level > maxLevel){
          theSelect.val('1');
        }
      //if level is relative, not 'the item', and absolutely >= maxLevel, set to '' (the item)...
      }else if(level !== '' && Math.abs(level) >= maxLevel){
        theSelect.val('');
      }

      oc.find('.cmw-set-rel-abs-levels').each(function(){
        var self = $(this),
            //.cmw-title-from fields use text "level N", the others use "to level N"...
            isTitleFrom = self.hasClass('cmw-title-from'),
            optgroups = self.find('optgroup'),
            ct = (optgroups.find('option').length / 2) + 1, //should never be below 2
            v = self.val(),
            minLevel = Math.max(2, maxLevel);
        if(Math.abs(v) >= maxLevel){
          self.val( v < 0 ? 1 - maxLevel : maxLevel - 1 );
        }
        if(ct !== minLevel){
          optgroups.each(function(i, el){
            var optgroup = $(el),
                text = getText( i ? (isTitleFrom ? 'level_n' : 'to_level_n') : 'n_levels' ),
                j;
            if(ct > minLevel){
              optgroup.find('option').slice( minLevel - ct ).remove();
            }
            for(j = ct; j < minLevel; j += 1){
              optgroup.append( $('<option/>', {value:i ? j : -j}).text( text.replace('%d', i ? j : -j) ) );
            }
          });
        }
      });

      oc.find('.cmw-include-level,.cmw-exclude-level').each(function(){
        var self = $(this),
            options = self.find('option'),
            ct = (options.length - 1) / 3,
            v = self.val(),
            above = options.eq(2).text(),
            below = options.eq(3).text();
        options.slice( (maxLevel * 3) + 1 ).remove();
        while(ct < maxLevel){
          ct += 1;
          self.append( $('<option/>', {value:ct}).text(ct) )
            .append( $('<option/>', {value:ct + '-'}).text(above.replace(/\d+/, ct)) )
            .append( $('<option/>', {value:ct + '+'}).text(below.replace(/\d+/, ct)) );
        }
        if(parseInt(v, 10) > maxLevel){
          self.val('');
        }
      });

      //do the easy levels...
      oc.find('.cmw-set-levels').each(function(){
        var self = $(this),
            txt = self.hasClass('cmw-level') ? '%d' : getText('n_levels'),
            leave = self.data('cmwSetLevels') || 0,
            opts = self.find('option'),
            ct = opts.length - leave;
        //if current value exceeds maxLevel, reset to first option...
        if(self.val() > maxLevel){
          self.val( opts.eq(0).val() );
        }
        //remove anything above maxLevel...
        self.find('option').slice(leave + maxLevel).remove();
        //append enough new options to bring up to maxLevel...
        while(ct < maxLevel){
          ct += 1;
          self.append( $('<option/>', {value:ct}).text( txt.replace('%d', ct) ) );
        }
      });
    }, //end cmwAssist.setLevels()

    setFields : function(target, oc){
      /**
       * enables/disables fields and swaps selected menus
       * @param {object} target jQuery of element responsible for 'change' event
       * @param {object} oc jQuery of the widget's onchange wrapper
       */
      var byBranchCheckbox = oc.find('.cmw-bybranch'),
          byItems = oc.find('.cmw-byitems').prop('checked'),
          notByBranch = byItems || !byBranchCheckbox.prop('checked'),
          menuItems = oc.find('.cmw-assist-items'),
          selectedItem = parseInt(menuItems.val(), 10),
          fallback, data;
      //change of menu? : make sure the correct optgroup of menu items is used...
      if(target.hasClass('cmw-select-menu')){
        selectedItem = swapItems(menuItems, selectedItem, target[0].selectedIndex);
        data = menuItems.find('optgroup').data() || {};
        this.setLevels(oc, data.cmwMaxLevel);
      //if level is changed, switch to by-level filtering...
      }else if(target.hasClass('cmw-level')){
        notByBranch = true;
        byItems = !notByBranch;
        oc.find('.cmw-bylevel').prop('checked', notByBranch);
      //if by-branch's branch is changed, switch to by-branch filtering...
      }else if(target.is(menuItems)){
        notByBranch = false;
        byItems = false;
        byBranchCheckbox.prop('checked', !notByBranch);
      //change of items?, switch to by-items filtering...
      }else if(target.hasClass('cmw-setitems')){
        byItems = true;
        notByBranch = byItems;
        oc.find('.cmw-byitems').prop('checked', byItems);
      //if ancestors is cleared, clear ancestor siblings...
      }else if(target.hasClass('cmw-ancestors') && target.val() === '0'){
        oc.find('.cmw-ancestor-siblings').val('0');
      //if include ancestor's siblings is changed to a value, and ancestors is empty, set ancestors from ancestor siblings...
      }else if(target.hasClass('cmw-ancestor-siblings') && target.val() !== '0' && oc.find('.cmw-ancestors').val() === '0'){
        oc.find('.cmw-ancestors').val( target.val() );
      }

      fallback = oc.find('.cmw-fallback').val();
      $.each( //disable if...
        { '-ss' : byItems, //...is Items
          '-ud' : byItems || oc.find('.cmw-depth').val() < 1, //...is Unlimited Depth
          'not-br' : notByBranch, //...is NOT Branch
          'not-br-ci' : notByBranch || !!selectedItem, //...is NOT Branch:Current Item
          'not-fb-pc' : notByBranch || !!selectedItem || (fallback !== 'parent' && fallback !== 'current'), //...is NOT fallback to parent or current
          'not-sw' : !!oc.find('.cmw-switchable').filter(function(){ return !$(this).val(); }).length //...is NOT switchable (missing rither condition or stage)
        },
        function(k, v){
          //as of v3.1.0, the input fields (+ selects, etc) are no longer disabled, because the customizer "pseudo-saves" the
          //form which wipes out values that you may not have wanted to lose!
          oc.find('.cmw-disableif' + k).toggleClass('cmw-colour-grey', v);
        });
    }, //end cmwAssist.setFields()

    shortcode : function(settings){
      /**
       * create and return the shortcode equivalent
       * @param {object} settings Widget settings
       * @return {string} Shortcode
       */
      var args = {
            'menu' : settings.menu
          },
          byBranch = settings.filter === 'branch',
          byItems = settings.filter === 'items',
          byLevel = !byBranch && !byItems,
          content, n;
      //take notice of the widget's hide_title flag...
      if(settings.title && !settings.hide_title){
        args.title = [settings.title];
      }
      //byLevel is the default (no branch & no items), as is level=1, so we only *have* to specify level if it's greater than 1...
      if(byLevel && settings.level > 1){
        args.level = settings.level;
      }
      //specifying branch sets byBranch, overriding byLevel...
      if(byBranch){
        args.branch = settings.branch || 'current';
        //start_at only *has* to be specified if not empty...
        if(settings.branch_start){
          args.start_at = [settings.branch_start];
        }
        //start_mode may be brought into play by a fallback so always specify it...
        if(settings.start_mode === 'level'){
          args.start_mode = ['level'];
        }
        //allow_all_root is only applicable to byBranch...
        if( settings.allow_all_root ){
          args.allow_all_root = 1;
        }
      }
      //specifying items set byItems, overriding byLevel & byBranch...
      if(byItems){
        n = '_items'; //avoids jslint warning
        args.items = [settings[n]];
      }
      //depth is not relevant to byItems...
      else{
        //depth if greater than 0...
        if(settings.depth > 0){
          args.depth = settings.depth;
        }
        //depth relative to current item is only applicable if depth is not unlimited...
        if(settings.depth_rel_current && settings.depth > 0){
          args.depth_rel_current = 1;
        }
      }
      //fallbacks...
      //no children : branch = current item...
      if(byBranch && !settings.branch){
        //format = quit|parent|current [,+siblings] [,depth] eg. "parent,+siblings,1" or "current,2" or "current,+siblings" or "parent" or "quit"
        if(settings.fallback){
          args.fallback = [settings.fallback];
          if(settings.fallback !== 'quit'){
            if(settings.fallback_siblings){
              args.fallback.push('+siblings');
            }
            if(settings.fallback_depth){
              args.fallback.push( settings.fallback_depth );
            }
          }
        }
      }
      //branch ancestor inclusions...
      if(byBranch && settings.ancestors){
        args.ancestors = settings.ancestors;
        if(settings.ancestor_siblings){
          args.ancestor_siblings = settings.ancestor_siblings;
        }
      }
      //inclusions by level...
      if(settings.include_level){
        args.include_level = [settings.include_level];
      }
      //exclusions by id...
      n = '_exclude'; //avoids jslint warning
      if(settings[n]){
        args.exclude = [settings[n]];
      }
      //...and by level...
      if(settings.exclude_level){
        args.exclude_level = [settings.exclude_level];
      }
      //title from...
      n = [];
      if(settings.title_current !== ''){
        n.push('current' + (!settings.title_current ? '' : settings.title_current));
      }
      if(byBranch && settings.title_branch !== ''){
        n.push('branch' + (!settings.title_branch ? '' : settings.title_branch));
      }
      if(n.length){
        args.title_from = n;
        //...title_linked is only relevant if title_from is set...
        if(settings.title_linked){
          args.title_linked = 1;
        }
      }
      //switches...
      $.each(
        [
          'siblings',
          'flat_output',
          'ol_root',
          'ol_sub',
          'fallback_ci_parent',
          'fallback_ci_lifo'
        ],
        function(ignore, k){
          if(settings[k]){
            args[k] = 1;
          }
        }
      );
      //strings...
      $.each(
        {
          contains_current:'',
          container:'div',
          container_id:'',
          container_class:'',
          menu_class:'menu-widget',
          widget_class:''
        },
        function(k,v){
          if(settings[k] !== v){
            args[k] = [settings[k]];
          }
        }
      );
      //mappings...
      $.each(
        {
          wrap_link:'before',
          wrap_link_text:'link_before'
        },
        function(k, v){
          var m = settings[v].toString().match(/^<(\w+)/);
          if(m && m[1]){
            args[k] = [m[1]];
          }
        }
      );
      //alternative...
      if(settings.switch_if){
        if(settings.switch_at){
          args.alternative = [settings.switch_if, settings.switch_at];
          content = alternativeStripDown(settings.switch_to);
        }
      }
      //build the shortcode...
      n = [];
      $.each(args, function(k, v){
        //array indicates join (with comma sep) & surround it in double quotes, otherwise leave 'as-is'...
        n.push( $.isArray(v) ? k + '="' + v.join(',') + '"' : k + '=' + v );
      });
      //NB at v3.0.0, the shortcode changed from custom_menu_wizard to cmwizard (the previous version is still supported)
      return '[cmwizard ' + n.join(' ') + (!content ? '/]' : ']' + content + '[/cmwizard]');
    }, //end cmwAssist.shortcode()

    structureUpdate : function(dialog, settings, usingAlts){
      /**
       * performs the filtering and update of the menu structure
       * note to self : this function must not alter whatever settings are passed into it, otherwise subsequent update
       *                actions, such as shortcode output, will be screwed!
       * @param {object} dialog jQuery of dialog
       * @param {array} settings Widget config
       * @param {integer} usingAlts Indicates whether alternative settings are being used or not
       * @return {boolean|array} False if completed, or the alternative settings if they should be applied
       */
      var tobLevel = -1,
          lastVisibleLevel = 9999,
          hasIncl = 0,
          hasExcl = 0,
          fallback = '',
          altSettings = null,
          theBranchItem, hasCurrent, topOfBranch, i, j, k, x, y,
          stage = 'menu',
          byBranch = settings.filter === 'branch',
          byItems = settings.filter === 'items',
          byLevel = !byBranch && !byItems,
          ciBranch = byBranch && !settings.branch,
          canSwitch = !usingAlts && !!settings.switch_if && !!settings.switch_at,
          topOfMenu = dialog.find('.cmw-demo-themenu-ul'),
          maxLevel = topOfMenu.data().maxLevel,
          currentItemLI = topOfMenu.find('.current-menu-item').closest('li'),
          currentItemLevel = currentItemLI.length ? currentItemLI.data().level : -1,
          items = topOfMenu.find('li').removeData('included').removeClass('title-from-item'),
          local_depth = settings.depth,
          local_depth_rel_current = settings.depth_rel_current,
          //ticks and crosses (need to be run against the full set of items)...
          exclusions = filterTickCross(items, settings, 'cross');

      //check for current item and switch...
      hasCurrent = items.length && currentItemLI.is(items);
      if(settings.contains_current === stage && !hasCurrent){
        items = $([]);
      }
      if(canSwitch && alternativeCheckFor(stage, hasCurrent, items.length, settings) ){
        altSettings = alternativeUse(settings, dialog);
        if(altSettings !== false){
          //cop out with alternative settings!...
          return altSettings;
        }
      }

      stage = 'primary';
      //primary filter : items...
      if(byItems && items.length){
        items = filterTickCross(items, settings, 'tick');
      }

      //primary filter : branch...
      if(byBranch && items.length){
        topOfBranch = ciBranch ? currentItemLI : items.filter('[data-itemid=' + settings.branch + ']');
        if(topOfBranch.length){
          tobLevel = topOfBranch.data().level || 0;
          items = topOfBranch.add( topOfBranch.find('li') );
          //since topOfBranch can change later on...
          theBranchItem = topOfBranch;
        }else{
          items = $([]);
        }
      }

      //primary filter : level...
      if(byLevel && items.length && settings.level > 1){
        j = [];
        for(i = 1; i < settings.level; i += 1){
          j.push('.level-' + i);
        }
        items = items.not( j.join(',') );
      }

      //check for current item and switch...
      hasCurrent = items.length && currentItemLI.is(items);
      if(settings.contains_current === stage && !hasCurrent){
        items = $([]);
      }
      if(canSwitch && alternativeCheckFor(stage, hasCurrent, items.length, settings) ){
        altSettings = alternativeUse(settings, dialog);
        if(altSettings !== false){
          //cop out with alternative settings!...
          return altSettings;
        }
      }

      stage = 'secondary';
      //secondary filter : level...
      if(byLevel && items.length && local_depth){
        i = ( local_depth_rel_current && currentItemLevel >= settings.level )
          //if the limited depth is relative to current item, and current item can be found at or below the start level...
          ? currentItemLevel
          //set relative to start level...
          : settings.level;
        i += local_depth;
        //note that i has been set to the first level *not* wanted!
        if(i <= maxLevel){
          for(j = []; i <= maxLevel; i += 1){
            j.push('.level-' + i);
          }
          //filter to remove...
          items = items.not( j.join(',') );
        }
      }

      //secondary filter : branch...
      if(byBranch && items.length){
        //convert start level to integer...
        j = parseInt(settings.branch_start, 10);
        //convert relative to absolute (max'd against 1)...
        j = ( isNaN(j) || !j ) ? tobLevel : ( settings.branch_start.match(/^(\+|-)/) ? Math.max(1, tobLevel + j) : j );

        //in order to be eligible for a no-kids fallback:
        // - branch must be current item
        // - fallback must be set
        // - current item has no kids
        if(ciBranch && settings.fallback && !currentItemLI.find('li').length){
          //yes, we have a fallback situation...
          fallback = 'cmw-fellback-to-' + settings.fallback;
          if(settings.fallback === 'quit'){
            //copout : just set secondary start level beyond maxLevel...
            j = maxLevel + 1;
          }else{
            //for current, fall back to tob; for parent, fall back to tob - 1, ensuring that we don't fall back further than root...
            j = ( settings.fallback === 'current' || tobLevel < 2 ) ? tobLevel : tobLevel - 1;
            //if fallback depth is specified, override depth and set to relative-to-current...
            if(settings.fallback_depth){
              local_depth = settings.fallback_depth;
              local_depth_rel_current = 1;
            }
          }
        }

        //j is the secondary start level, tobLevel is the primary level
        //easy result : if j > maxLevel then there are no matches...
        if(j > maxLevel){
          items = $([]);
        }else{
          //if secondary start is higher up the structure than primary start, reset the tob...
          if(j < tobLevel){
            topOfBranch = topOfBranch.parentsUntil(topOfMenu, 'li.level-' + j);
          }
          //do we want (and need) to force starting with the entire level...
          // - only relevant if secondary start is at or above primary start
          // - and if secondary level is root then allow_all_root must be set
          if(settings.start_mode === 'level' && j <= tobLevel && (j > 1 || settings.allow_all_root)){
            //...reset items to eveything at tob's level, plus all their descendants...
            items = topOfBranch.parent().find('li');
          }else if(j < tobLevel){
            //tob has changed so reset items (to just tob and descendants)...
            items = topOfBranch.add( topOfBranch.find('li') );
          }
          //if falling back and siblings are required, add them in...
          //note that root level sibling inclusion is still governed by allow_all_root!
          if(!!fallback && settings.fallback_siblings && items.length && (j > 1 || settings.allow_all_root)){
            items = items.add( topOfBranch.siblings('li.level-' + j) );
          }
        }
        //may have a tob but might not have any items!...
        if(items.length){
          //reset tob level (regardless of whether tob has changed)...
          tobLevel = j;
          //is depth unlimited?...
          k = 9999;
          if(local_depth){
            //is (limited) depth relative to current item, and is there an eligible current item to measure against?...
            k = ( local_depth_rel_current && currentItemLevel >= tobLevel && items.filter(currentItemLI).length )
              ? currentItemLevel
              : tobLevel;
            k += local_depth;
            lastVisibleLevel = k - 1;
          }
          //note that k has been set to the first level (after those wanted) that is *not* wanted!
          j = [];
          for(i = 1; i <= maxLevel; i += 1){
            if(i >= tobLevel && i < k){
              j.push('.level-' + i);
            }
          }
          //filter to keep...
          items = items.filter( j.join(',') );
        }
      }

      //check for current item and switch...
      hasCurrent = items.length && currentItemLI.is(items);
      if(settings.contains_current === stage && !hasCurrent){
        items = $([]);
      }
      if(canSwitch && alternativeCheckFor(stage, hasCurrent, items.length, settings) ){
        altSettings = alternativeUse(settings, dialog);
        if(altSettings !== false){
          //cop out with alternative settings!...
          return altSettings;
        }
      }

      stage = 'inclusions';
      //branch inclusions...
      //NB: only applicable if there are already items
      if(byBranch && items.length){
        //branch ancestors, possibly with their siblings : but only if the original branch item is either
        //in items or is below lastVisibleLevel; ALSO, do not show ancestors below lastVisibleLevel!
        j = theBranchItem.data().level;
        if(settings.ancestors && (theBranchItem.is(items) || j > lastVisibleLevel)){
          x = settings.ancestors;
          //convert a relative level to an absolute one...
          if(x < 0){
            x = Math.max(1, j + x);
          }
          //ancestor siblings?...
          y = settings.ancestor_siblings;
          //convert a relative level to an absolute one...
          if(y < 0){
            y = Math.max(1, j + y);
          }
          //get the level classes for ancestors and siblings that need to be included...
          j = [];
          k = [];
          for(i = x; i <= maxLevel; i += 1){
            if(i <= lastVisibleLevel){
              //ancestors...
              j.push('.level-' + i);
              if(y > 0 && i >= y){
                //siblings...
                k.push('.level-' + i);
              }
            }
          }
          //store current length of items...
          x = items.length;
          //find the ancestors...
          j = theBranchItem.parentsUntil(topOfMenu, j.join(','));
          //add new ones into items...
          items = items.add( j.not(items).data('included', ' cmw-an-included-ancestor') );
          //got ancestors, now what about their siblings?...
          if(k.length){
            //filter ancestors for those we want siblings of, and add new siblings into items...
            items = items.add( j.filter( k.join(',') ).siblings('li').not(items).data('included', ' cmw-an-included-ancestor-sibling') );
          }
          //note how many have been added to items as a result of the includes...
          hasIncl += items.length - x;
        }
        //branch siblings : only if the original branch item is currently in items...
        if(settings.siblings && theBranchItem.is(items)){
          j = items.length;
          items = items.add( theBranchItem.siblings('li').data('included', ' cmw-an-included-sibling') );
          hasIncl += items.length - j;
        }
      }
      //other inclusions...
      if(items.length && !!settings.include_level){
        k = getLevelClasses(settings.include_level, maxLevel);
        if(k){
          //find and add...
          j = items.length;
          items = items.add( topOfMenu.find(k) );
          hasIncl += items.length - j;
        }
      }

      //check for current item and switch...
      hasCurrent = items.length && currentItemLI.is(items);
      if(settings.contains_current === stage && !hasCurrent){
        items = $([]);
      }
      if(canSwitch && alternativeCheckFor(stage, hasCurrent, items.length, settings) ){
        altSettings = alternativeUse(settings, dialog);
        if(altSettings !== false){
          //cop out with alternative settings!...
          return altSettings;
        }
      }

      stage = 'output';
      //exclusions...
      if(items.length && exclusions.length){
        //filter to remove...
        j = items.length;
        items = items.not(exclusions);
        hasExcl += j - items.length;
      }
      if(items.length && !!settings.exclude_level){
        k = getLevelClasses(settings.exclude_level, maxLevel);
        if(k){
          //filter to remove...
          j = items.length;
          items = items.not(k);
          hasExcl += j - items.length;
        }
      }

      //check for current item and switch...
      hasCurrent = items.length && currentItemLI.is(items);
      if(settings.contains_current === stage && !hasCurrent){
        items = $([]);
      }
      if(canSwitch && alternativeCheckFor(stage, hasCurrent, items.length, settings) ){
        altSettings = alternativeUse(settings, dialog);
        if(altSettings !== false){
          //cop out with alternative settings!...
          return altSettings;
        }
      }

      //title from...
      if(settings.title_current !== '' && currentItemLI.length){
        if(settings.title_current === 0){
          currentItemLI.addClass('title-from-item');
        }else{
          i = settings.title_current > 0 ? Math.min(currentItemLevel, settings.title_current) : Math.max(1, currentItemLevel + settings.title_current);
          currentItemLI.closest('.level-' + i).addClass('title-from-item');
        }
      }else if(byBranch && theBranchItem && settings.title_branch !== ''){
        if(settings.title_branch === 0){
          theBranchItem.addClass('title-from-item');
        }else{
          i = theBranchItem.data().level;
          i = settings.title_branch > 0 ? Math.min(i, settings.title_branch) : Math.max(1, i + settings.title_branch);
          theBranchItem.closest('.level-' + i).addClass('title-from-item');
        }
      }

      //show/hide the fall back message...
      dialog.find('.cmw-demo-fallback').data('fellback', fallback).toggleClass('updated', !!fallback);
      //show/hide the 'select current item' prompt...
      dialog.find('.cmw-demo-setcurrent').toggleClass('error', !currentItemLI.length && (!!settings.contains_current || ciBranch));
      //hide the alternative message if not using - and haven't tried to use! - alternative settings...
      if(!usingAlts && altSettings === null){
        dialog.find('.cmw-demo-alternative').removeClass('error updated');
      }
      //...and toggle the demo menu structure's class (eg. applies an opacity to the ticks/crosses if alternative settings
      //   are being used, and prevents them being clicked on - because they can't be updated back into the current settings)...
      dialog.find('.cmw-demo-themenu-ul').toggleClass('cmw-using-alternative', !!usingAlts);
      //show/hide the inclusions/exclusions messages...
      $.each(
        {
          inclusions: hasIncl,
          exclusions: hasExcl
        },
        function(k, v){
          var el = dialog.find('.cmw-demo-' + k);
          el.text( el.text().replace(/\d+$/, v) ).toggleClass('updated', v > 0);
        }
      );

      //toggle ticks and 'pick' the remaining items...
      topOfMenu.toggleClass('cmw-demo-filteritems', byItems)
        .find('.picked').not( items.addClass('picked') ).removeClass('picked');

      //returning false means we're done!...
      return false;

    }, //end cmwAssist.structureUpdate()

    update : function(el){
      /**
       * updates the graphic menu structure from the widget data
       * @param {element} el Element responsible for being here
       */
      var target = $(el),
          oc = findOnchange(target), //above
          dialog = $('#' + oc.data().cmwDialogId),
          settings, altSettings;

      if(target.hasClass('cmw-listen')){
        //the widget field that changed is likely to have an effect on other widget fields...
        this.setFields(target, oc);
      }
      settings = getSettings(oc);

      //dialog specific...
      if(dialog.length && dialog.dialog('isOpen')){
        dialog.dialog('moveToTop');
        //if selected menu has changed, modify assist's structure...
        if(target.hasClass('cmw-select-menu')){
          createMenu(dialog);
        }

        //if it's determined that altSettings should be used then they are intially returned and the structure update
        //is re-run with those settings (and an indicator to say that alts are bing used). otherwise, the structure
        //update simply returns false to say that the original settings should be used (either because alts don't apply,
        //or because the alts that we've got are not valid and can't be used)
        altSettings = this.structureUpdate(dialog, settings);
        if(altSettings !== false){
          //don't care what this returns (should only be false!) because we're not going to run it again...
          this.structureUpdate(dialog, altSettings, true);
        }

        //produce output...
        setDialogTitle(dialog, oc);
        //show output with whichever settings we ended up using...
        showOutput(dialog, altSettings || settings);
        altSettings = null;
      } //end dialog specific

      //always use original settings to update the shortcode displays...
      oc.add(dialog).find('code').not('.cmw-instance-shortcode').text( this.shortcode( settings ) );

    } //end cmwAssist.update()

  }; //end cmwAssist

  /**
   * pre-v3.0.0 version
   */
  cmwAssist.v210 = {
    setLevels : function(oc, maxLevel){
      /**
       * sets any fields that are dependent on the selected menu
       * @param {object} oc jQuery of the widget's onchange wrapper
       * @param {integer} maxLevel Maximum level of the selected menu
       */
      var theSelect = oc.find('.cmw-start-level'),
          level = theSelect.val(),
          ct = theSelect.find('option').length;
      if(level > maxLevel){
        theSelect.val(1);
      }
      theSelect.find('option').slice(maxLevel).remove();
      while(ct < maxLevel){
        ct += 1;
        theSelect.append( $('<option/>', {value:ct}).text(ct) );
      }
      theSelect = oc.find('.cmw-depth');
      level = theSelect.val();
      ct = theSelect.find('option').length;
      if(level > maxLevel){
        theSelect.val(0); //=unlimited
      }
      theSelect.find('option').slice(maxLevel + 1).remove();
      while(ct <= maxLevel){
        theSelect.append( $('<option/>', {value:ct}).text(ct) );
        ct += 1;
      }
    }, //end cmwAssist.v210.setLevels()

    setFields : function(target, oc){
      /**
       * enables/disables fields and swaps selected menus
       * @param {object} target jQuery of element responsible for 'change' event
       * @param {object} oc jQuery of the widget's onchange wrapper
       */
      var showAll = oc.find('.cmw-showall').prop('checked'),
          showSpecific = oc.find('.cmw-showspecific').prop('checked'),
          menuItems = oc.find('.cmw-assist-items'),
          selectedItem = parseInt(menuItems.val(), 10),
          data;
      //change of menu? : make sure the correct optgroup of menu items is used...
      if(target.hasClass('cmw-select-menu')){
        selectedItem = swapItems(menuItems, selectedItem, target[0].selectedIndex);
        data = menuItems.find('optgroup').data() || {};
        this.setLevels(oc, data.cmwMaxLevel);
      }
      $.each(
        { '' : showAll || showSpecific,
          '-ss' : showSpecific,
          'not-rp' : showAll || showSpecific || selectedItem >= 0,
          'not-ci' : showAll || showSpecific || !!selectedItem
        },
        function(k, v){
          oc.find('.cmw-disableif' + k).toggleClass('cmw-colour-grey', v).find('input,select').prop('disabled', v);
        });
    }, //end cmwAssist.v210.setFields()

    shortcode : function(settings){
      /**
       * create and return the shortcode equivalent
       * @param {object} settings Widget settings
       * @return {string} Shortcode
       */
      var args = {
            'menu' : settings.menu
          },
          byLevel = !settings.filter,
          byBranch = settings.filter > 0,
          byItems = !byLevel && !byBranch,
          n;
      if(settings.title){
        args.title = [settings.title];
      }
      if(byBranch){
        switch(settings.filter_item){
          case 0: args.children_of = ['current']; break;
          case -1: args.children_of = ['parent']; break;
          case -2: args.children_of = ['root']; break;
          default:
            args.children_of = settings.filter_item;
        }
      }
      if(byItems){
        n = '_items';
        args.items = [settings[n]];
      }
      if(byBranch && settings.filter_item < 0 && settings.fallback_no_ancestor){
        if(settings.fallback_include_parent_siblings){
          args.fallback_parent = ['siblings'];
        }else if(settings.fallback_include_parent){
          args.fallback_parent = ['parent'];
        }else{
          args.fallback_parent = 1;
        }
      }
      if(byBranch && !settings.filter_item && settings.fallback_no_children){
        if(settings.fallback_nc_include_parent_siblings){
          args.fallback_current = ['siblings'];
        }else if(settings.fallback_nc_include_parent){
          args.fallback_current = ['parent'];
        }else{
          args.fallback_current = 1;
        }
      }
      if(settings.start_level > 1){
        args.start_level = settings.start_level;
      }
      if(settings.depth > 0){
        args.depth = settings.depth;
      }
      //depth relative to current item is only applicable if depth is not unlimited...
      if(settings.depth_rel_current && settings.depth > 0){
        args.depth_rel_current = 1;
      }
      n = [];
      if(byBranch){
        if(settings.include_parent_siblings){
          n.push('siblings');
        }else if(settings.include_parent){
          n.push('parent');
        }
        if(settings.include_ancestors){
          n.push('ancestors');
        }
        if(n.length){
          args.include = n;
        }
      }
      n = [];
      if(byBranch && settings.title_from_parent){
        n.push('parent');
      }
      if(settings.title_from_current){
        n.push('current');
      }
      if(n.length){
        args.title_from = n;
      }
      $.each(
        [
          'flat_output',
          'contains_current',
          'ol_root',
          'ol_sub'
        ],
        function(ignore, k){
          if(settings[k]){
            args[k] = 1;
          }
        }
      );
      $.each(
        {
          container:'div',
          container_id:'',
          container_class:'',
          menu_class:'menu-widget',
          widget_class:''
        },
        function(k, v){
          if(settings[k] !== v){
            args[k] = [settings[k]];
          }
        }
      );
      $.each(
        {
          wrap_link:'before',
          wrap_link_text:'link_before'
        },
        function(k, v){
          var m = settings[v].toString().match(/^<(\w+)/);
          if(m && m[1]){
            args[k] = [m[1]];
          }
        }
      );
      n = [];
      $.each(args, function(k, v){
        //array indicates join (with space sep) & surround it in double quotes, otherwise leave 'as-is'...
        n.push( $.isArray(v) ? k + '="' + v.join(' ') + '"' : k + '=' + v );
      });
      return '[custom_menu_wizard ' + n.join(' ') + ']';
    }, //end cmwAssist.v210.shortcode()

    update : function(el){
      /**
       * updates the graphic menu structure from the widget data
       * @param {element} el Element responsible for being here
       */
      var target = $(el),
          oc = findOnchange(target), //above
          dialog = $('#' + oc.data().cmwDialogId),
          byLevel, byBranch, byItems,
          maxLevel, settings, includeParent, includeParentSiblings, topOfMenu, items,
          currentItemLI, currentItemLevel, fallback, parent, i, j;

      if(target.hasClass('cmw-listen')){
        //the widget field that changed is likely to have an effect on other widget fields...
        this.setFields(target, oc);
      }

      //everything below this point is dialogue-related...
      if(!dialog.length || !dialog.dialog('isOpen')){
        return;
      }
      dialog.dialog('moveToTop');

      //if selected menu has changed, modify assist's structure...
      if(target.hasClass('cmw-select-menu')){
        createMenu(dialog);
      }
      settings = getSettings(oc);
      byLevel = !settings.filter;
      byBranch = settings.filter > 0;
      byItems = !byLevel && !byBranch;
      includeParent = settings.include_parent;
      includeParentSiblings = settings.include_parent_siblings;
      topOfMenu = dialog.find('.cmw-demo-themenu-ul');
      maxLevel = topOfMenu.data().maxLevel;
      currentItemLI = topOfMenu.find('.current-menu-item').closest('li');
      currentItemLevel = currentItemLI.length ? currentItemLI.data().level : -1;
      items = topOfMenu.find('li').removeData('included').removeClass('title-from-item');

      if(byItems){
        items = filterTickCross(items, settings, 'tick');
      }

      if(items.length && !currentItemLI.length && (settings.contains_current || (byBranch && settings.filter_item < 1))){
        items = $([]);
      }

      if(items.length && byBranch){
        //kids of...
        if(settings.filter_item > 0){
          //specific item...
          parent = items.filter('[data-itemid=' + settings.filter_item + ']');
        }else if(!settings.filter_item){
          //current...
          if(currentItemLI.find('li').length){
            parent = currentItemLI;
          }else if(settings.fallback_no_children){
            //fall back to current parent...
            parent = topOfMenu.find('.current-menu-parent').closest('li');
            if(!parent.length){
              parent = topOfMenu; //beware!
            }
            includeParent = includeParent || settings.fallback_nc_include_parent;
            includeParentSiblings = includeParentSiblings || settings.fallback_nc_include_parent_siblings;
            fallback = 'cmw-fellback-to-parent';
          }
        }else{
          //parent or root...
          if(currentItemLevel === 1 && settings.fallback_no_ancestor){
            parent = currentItemLI;
            includeParent = includeParent || settings.fallback_include_parent;
            includeParentSiblings = includeParentSiblings || settings.fallback_include_parent_siblings;
            fallback = 'cmw-fellback-to-current';
          }else if(currentItemLevel === 1){
            parent = topOfMenu; //beware!
          }else if(settings.filter_item < -1){
            parent = topOfMenu.find('.current-menu-ancestor').eq(0).closest('li');
          }else{
            parent = topOfMenu.find('.current-menu-parent').closest('li');
          }
        }
      }

      if(items.length){
        if(byLevel){
          //showall : use the levels...
          if(settings.depth_rel_current && settings.depth && currentItemLI.length && currentItemLevel >= settings.start_level){
            j = currentItemLevel + settings.depth - 1;
          }else{
            j = settings.depth ? settings.start_level + settings.depth - 1 : 9999;
          }
          for(i = 1; i <= maxLevel; i += 1){
            if(i < settings.start_level || i > j){
              items = items.not('.level-' + i);
            }
          }
        }else if(parent && parent.length){
          //kids of...
          if(settings.depth_rel_current && settings.depth && currentItemLI.length && parent.has(currentItemLI[0]).length){
            j = currentItemLevel - 1 + settings.depth;
          }else{
            j = settings.depth ? Math.max( (parent.data().level || 0) + settings.depth, settings.start_level + settings.depth - 1 ) : 9999;
          }
          items = parent.find('li').filter(function(){
            var level = $(this).data().level;
            return level >= settings.start_level && level <= j;
          });
        }else if(byBranch){
          //kids-of, but no parent found...
          items = $([]);
        }
      }

      if(items.length){
        if(byBranch && parent && parent.is('li')){
          //kids of an item...
          if(includeParentSiblings){
            items = items.add( parent.siblings('li').data('included', ' cmw-an-included-parent-sibling') );
            includeParent = true;
          }
          if(settings.include_ancestors){
            items = items.add( parent.parentsUntil(topOfMenu, 'li').data('included', ' cmw-an-included-ancestor') );
            includeParent = true;
          }
          if(includeParent){
            items = items.add( parent.data('included', ' cmw-the-included-parent') );
          }
        }
      }

      //must contain current item?...
      if(items.length && settings.contains_current && (!currentItemLI.length || !items.filter(currentItemLI).length)){
        items = $([]);
      }

      //title from parent has higher priority than title from current...
      if(settings.title_from_parent && items.length && parent && parent.is('li')){
        parent.addClass('title-from-item');
      }else if(settings.title_from_current && items.length){
        currentItemLI.addClass('title-from-item');
      }
      //fallback?...
      fallback = items.length ? fallback : '';
      dialog.find('.cmw-demo-fallback').data('fellback', fallback).toggleClass('updated', !!fallback);
      //show/hide the 'select current item' prompt...
      dialog.find('.cmw-demo-setcurrent').toggleClass('error', !currentItemLI.length && (settings.contains_current || (byBranch && settings.filter_item < 1)));

      //toggle ticks and 'pick' the remaining items...
      topOfMenu.toggleClass('cmw-demo-filteritems', byItems)
        .find('.picked').not( items.addClass('picked') ).removeClass('picked');
      //produce output...
      setDialogTitle(dialog, oc);
      showOutput(dialog, settings);
      dialog.find('code').text( this.shortcode(settings) );
    } //end cmwAssist.v210.update()
  }; //end cmwAssist.v210

  $(document)
    //any change event on widget's inputs or selects...
    .on('change', widgetCustomMenuWizardClass('onchange', 1), assistance)
    //open/close assist dialog...
    .on('click', widgetCustomMenuWizardClass('assist', 1), clickAssist)
    //expand/collapse fieldsets...
    .on('click', widgetCustomMenuWizardClass('fieldset', 1), clickFieldset)
    //when a widget is closed, close its open dialog...
    .on('click', '.widget-action,.widget-control-close', closeDialog)
    //when a widget is deleted, remove its dialog...
    .on('click', '.widget-control-remove', removeDialog)
    //collapse/expand assist menu tree items...
    .on('click', widgetCustomMenuWizardClass('colexp', 1), clickTreeExpander)
    //find posts containing shortcodes by ajax...
    .on('click', widgetCustomMenuWizardClass('find-shortcodes', 1), clickFindShortcodes)
    //remove the legacy warning...
    .on('click', widgetCustomMenuWizardClass('legacy-close', 1), function(){
      $(this).parent().remove();
      return false;
    });

  //editing in accessibility mode...
  if(!!window.Custom_Menu_Wizard_Widget){
    $(window.Custom_Menu_Wizard_Widget.trigger || []).trigger('change');
  }
});
