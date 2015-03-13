/**
 * appCalendarPicker
 *
 * @author     Marc Costa <cbmarc@gmail.com>
 * @version    1.0.0 (last revision: February 24, 2015)
 * @copyright  (c) 2015 Marc Costa
 * @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU LESSER GENERAL PUBLIC LICENSE
 * @package    appCalendarPicker
 */

/*
 * Example:
 * 
 *  <div class="testCalendar"></div>
 *  
 *  $(".testCalendar").appCalendarPicker({
 *    datesStart: '2015-02-09 04:20:00,2015-02-18 03:10:00',
 *    datesEnd: '2015-02-09 04:30:00,2015-02-18 11:40:00',
 *    onUpdate: function(datesStart, datesEnd){
 *      console.log("Start Dates: " + datesStart + ' End Dates: ' + datesEnd);
 *    }
 *  });
 */
;(function($) {
    
    'use strict';
    
    $.appCalendarPicker = function(element, options) {
        
        // Establish our default settings
        var settings = $.extend({
            // Start dates in format: "yy-mm-dd HH:ii:ss, ..."
            datesStart: '',
            
            // End dates in format: "yy-mm-dd HH:ii:ss, ..."
            datesEnd: '',
            
            // Callback function is empty by default
            onUpdate: function(datesStart, datesEnd) {}
        }, options );
        
        var plugin = this;
        
        var $element = $(element);
        
        // Callback function is empty by default
        //var onUpdate = function() {};
        
        // private properties
        var datesArrStart, datesArrEnd, dateswotimesArr, dateFormat,
            datepicker, timepickerStart, timepickerEnd,
            buttonAdd, buttonDel, buttonDelAll;
        
        /**
         *  Constructor method. Initializes the plugin.
         *
         *  @return void
         */
        var init = function() {
            $element.addClass('appCalendarPicker');
            
            var css = '<style type="text/css">' +
            	'div.ui-datepicker { font-size:14px; }' + 
                '.appCalendarPicker td.ui-state-appseleccted a {background:#81F781 !important}' +
                '.appCalendarPicker .ui-widget-content .ui-state-active {background: #e6e6e6;border:1px solid #f00;}' +
                '.appCalendarPicker .ui-widget-content .ui-state-highlight {background: #fff;}' +
                '</style>';
            
            $(css).appendTo('head');
            
            datepicker = $('<div></div>').appendTo($element);
            timepickerStart = $('<div></div>').appendTo($element);
            timepickerEnd = $('<div></div>').appendTo($element);
            
            var buttonPanel = $('<div style="margin: 10px 0;"></div>').appendTo($element);
            
            buttonDelAll = $('<input style="margin: 0 12px 0 0" type="button" class="button button-disabled" value="Borrar tot">').appendTo(buttonPanel);
            buttonAdd = $('<input style="margin: 0 12px 0 0" type="button" class="button button-disabled" value="Afegir">').appendTo(buttonPanel);
            buttonDel = $('<input type="button" class="button button-disabled" value="Borrar">').appendTo(buttonPanel);
            
            buttonDelAll.click(function(){buttonDelAllClick()});
            buttonAdd.click(function(){buttonAddClick()});
            buttonDel.click(function(){buttonDelClick()});
            
            datesArrStart = new Array();
            datesArrEnd = new Array();
            
            // only dates without hours
            dateswotimesArr = new Array();
            
            dateFormat = 'yy-mm-dd';
            
            if (settings.datesStart) {
                datesArrStart = settings.datesStart.split(',');
                datesArrEnd = settings.datesEnd.split(',');
                
                updateDates();
            }
            
            datepicker.datepicker({
                numberOfMonths: 1,
                dateFormat: dateFormat,
                onSelect: function (date) {
                    refresh();
                },
                beforeShowDay: function (date) {
                    var mydate = $.datepicker.formatDate(
                        dateFormat, date);
            
                    if (getDateIndex(mydate) >= 0)
                        return [true, "ui-state-appseleccted"];
            
                    return [true, ""];
                }
            });
            
            timepickerStart.timepicker({
                timeOnlyTitle: 'Hora d\'inici',
                showButtonPanel: false,
                stepMinute: 5
            });
            
            timepickerEnd.timepicker({
                timeOnlyTitle: 'Hora final',
                showButtonPanel: false,
                stepMinute: 5
            });
            
            refresh();
        };
        
        // --------------------------------------------------------------------
        
        /**
	     * buttonAddClick method
         *
         * @return void
	     */
        var buttonAddClick = function() {            
            var dateString = getDateString();
            var timeStartString = getTimeStartString();
            var timeEndString = getTimeEndString();
            
            if(timeStartString > timeEndString) {
                alert("La hora d'inici és posterior a la hora final.");
                
                return;
            }
        
            // data completa "yy-mm-dd HH:mm:00"
            var dateTimeStartString = dateString + " " + timeStartString + ':00';
            var dateTimeEndString = dateString + " " + timeEndString + ':00';
            
            var index = getDateIndex(dateString);
            if (index >= 0) {
                datesArrStart[index] = dateTimeStartString;
                datesArrEnd[index] = dateTimeEndString;
            } else {
                datesArrStart.push(dateTimeStartString);
                datesArrEnd.push(dateTimeEndString);
            }
            
            refresh();
        };
        
        // --------------------------------------------------------------------
        
        /**
	     * buttonDelClick method
         *
         * @return void
	     */
        var buttonDelClick = function() {
            var dateString = getDateString();
            
            var index = getDateIndex(dateString);
            if (index >= 0) {
                datesArrStart.splice(index, 1);
                datesArrEnd.splice(index, 1);
            }
        
            refresh();
        };
        
        // --------------------------------------------------------------------
        
        /**
	     * buttonDelAllClick method
         *
         * @return void
	     */
        var buttonDelAllClick = function() {
            datesArrStart = new Array();
            datesArrEnd = new Array();
            
            refresh();
        };
        
        // --------------------------------------------------------------------
        
        /**
	     * getDateIndex method
	     *
	     * @param string date
         *
         * @return integer Element index or -1 if not found
	     */
        var getDateIndex = function(date) {
            return $.inArray(date, dateswotimesArr);
        };
        
        // --------------------------------------------------------------------
        
        /**
	     * updateDates method
	     *
         * Update dates without times in array
         *
         * @return void
	     */
        var updateDates = function() {
            dateswotimesArr = $.map(datesArrStart, function (val, i) {
                return $.datepicker.formatDate(dateFormat, new Date(val));
            });
        };
        
        // --------------------------------------------------------------------
        
        /**
	     * refresh method
	     *
         * Refresh Calendar
         *
         * @return void
	     */
        var refresh = function()
        {
            var dateString = getDateString();
            
            updateDates();
            
            settings.onUpdate.call(
                    this, datesArrStart, datesArrEnd);
            
            datepicker.datepicker("refresh");
                        
            if(datesArrStart.length)
            	buttonDelAll.removeClass("button-disabled").addClass('button-primary');
            else
            	buttonDelAll.removeClass("button-primary").addClass('button-disabled');
        
            var index = getDateIndex(dateString);
            if (index >= 0) {
                timepickerStart.datetimepicker("setDate", new Date(datesArrStart[index]));
                timepickerEnd.datetimepicker("setDate", new Date(datesArrEnd[index]));
                
                buttonAdd.val('Modificar');
                buttonAdd.removeClass("button-disabled").addClass('button-primary');
                buttonDel.removeClass("button-disabled").addClass('button-primary');
            } else {
                // reset timepicker
                timepickerStart.datetimepicker("setDate", new Date(dateFormat));
                timepickerEnd.datetimepicker("setDate", new Date(dateFormat));
                
                buttonAdd.val('Afegir');
                buttonDel.removeClass("button-primary").addClass('button-disabled');
                buttonAdd.removeClass("button-disabled").addClass('button-primary');
            }
        };
        
        // --------------------------------------------------------------------
        
        /**
	     * getDateString method
         *
         * @return void
	     */
        var getDateString = function() {
            var dateObject = datepicker.datepicker("getDate");
            
            return $.datepicker.formatDate(dateFormat, dateObject);
        };

        // --------------------------------------------------------------------
        
        /**
	     * getTimeStartString method
         *
         * @return void
	     */        
        var getTimeStartString = function() {
            var timeObject = timepickerStart.datetimepicker('getDate');
            
            var timeDefault = {hour: 0,minute: 0};
            if (timeObject) 
                timeDefault = {hour: timeObject.getHours(), minute: timeObject.getMinutes()};
            
            return $.datepicker.formatTime('HH:mm', timeDefault);
        };

        // --------------------------------------------------------------------
        
        /**
	     * getTimeEndString method
         *
         * @return void
	     */        
        var getTimeEndString = function() {
            var timeObject = timepickerEnd.datetimepicker('getDate');
            
            var timeDefault = {hour: 0,minute: 0};
            if (timeObject) 
                timeDefault = {hour: timeObject.getHours(), minute: timeObject.getMinutes()};
            
            return $.datepicker.formatTime('HH:mm', timeDefault);
        };
        
        // initialize the plugin
        init();
    };
    
    $.fn.appCalendarPicker = function(options) {
        
        // Iterate through all the elements to which we need to attach
        return this.each(function(i, el) {
            
            // Create an instance of the plugin
            var plugin = new $.appCalendarPicker(this, options);
            
        });
        
    }
    
}( jQuery ));