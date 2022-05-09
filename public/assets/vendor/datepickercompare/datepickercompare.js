/* 
 * 'Date Range Comparison Picker 2.2.0'
 *	Gelecek dönem tarihlerini seçme özelliği eklendi;
                selectFutureDay	 : false / true
      selectDisableDay : false / true
      
 * improving the plugin to works like Google Analytics Specifications. by Muammer Keleş.
 *
 * Thanks to first developer is Justin Stern.
 * I have keep to improve after his releases version 1.0.0.
 * --------------
 * Version 1.0.0 notes by Justin are below
 *
 * A jQuery-based DatePicker that provides an easy way of creating both single
 * and multi-viewed calendars capable of accepting single, range, and multiple
 * selected dates.  Easily styled with two example styles provided: an attractive
 * 'dark' style, and a Google Analytics-like 'clean' style.
 * 
 * View project page for Examples and Documentation:
 * http://foxrunsoftware.github.com/DatePicker/
 * 
 * This project is distinct from and not affiliated with the jquery.ui.datepicker.
 * 
 * Copyright 2012, Justin Stern (www.foxrunsoftware.net)
 * Dual licensed under the MIT and GPL Version 2 licenses.
 * 
 * Based on Work by Original Author: Stefan Petre www.eyecon.ro
 * 
 * Depends:
 *   jquery-1.12.4
 *   Bootstrap 3 (optional)
 */
(function ($) {
    var DatePicker = function () {
        var ids = {},
            views = {
                years: 'datepickerViewYears',
                moths: 'datepickerViewMonths',
                days: 'datepickerViewDays'
            },
            tpl = {
                wrapper: '<div class="datepicker"><div class="datepickerBorderT" /><div class="datepickerBorderB" /><div class="datepickerBorderL" /><div class="datepickerBorderR" /><div class="datepickerBorderTL" /><div class="datepickerBorderTR" /><div class="datepickerBorderBL" /><div class="datepickerBorderBR" /><div class="datepickerContainer animated fadeInRight"><table cellspacing="0" cellpadding="0"><tbody><tr></tr></tbody></table></div></div>',
                head: [
                    '<td class="datepickerBlock">',
                    '<table cellspacing="0" cellpadding="0">',
                    '<thead>',
                    '<tr>',
                    '<th colspan="7" class="hmtitle"><a class="datepickerGoPrev" href="#"><span><%=prev%></span></a>',
                    '<a class="datepickerMonth" href="#"><span></span></a>',
                    '<a class="datepickerGoNext" href="#"><span><%=next%></span></a></th>',
                    '</tr>',
                    '<tr class="datepickerDoW">',
                    '<th><span><%=day1%></span></th>',
                    '<th><span><%=day2%></span></th>',
                    '<th><span><%=day3%></span></th>',
                    '<th><span><%=day4%></span></th>',
                    '<th><span><%=day5%></span></th>',
                    '<th><span><%=day6%></span></th>',
                    '<th><span><%=day7%></span></th>',
                    '</tr>',
                    '</thead>',
                    '</table></td>'
                ],
                space: '<td class="datepickerSpace"><div></div></td>',
                days: [
                    '<tbody class="datepickerDays">',
                    '<tr>',
                    '<td class="<%=weeks[0].days[0].classname%>"><a href="#"><span><%=weeks[0].days[0].text%></span></a></td>',
                    '<td class="<%=weeks[0].days[1].classname%>"><a href="#"><span><%=weeks[0].days[1].text%></span></a></td>',
                    '<td class="<%=weeks[0].days[2].classname%>"><a href="#"><span><%=weeks[0].days[2].text%></span></a></td>',
                    '<td class="<%=weeks[0].days[3].classname%>"><a href="#"><span><%=weeks[0].days[3].text%></span></a></td>',
                    '<td class="<%=weeks[0].days[4].classname%>"><a href="#"><span><%=weeks[0].days[4].text%></span></a></td>',
                    '<td class="<%=weeks[0].days[5].classname%>"><a href="#"><span><%=weeks[0].days[5].text%></span></a></td>',
                    '<td class="<%=weeks[0].days[6].classname%>"><a href="#"><span><%=weeks[0].days[6].text%></span></a></td>',
                    '</tr>',
                    '<tr>',
                    '<td class="<%=weeks[1].days[0].classname%>"><a href="#"><span><%=weeks[1].days[0].text%></span></a></td>',
                    '<td class="<%=weeks[1].days[1].classname%>"><a href="#"><span><%=weeks[1].days[1].text%></span></a></td>',
                    '<td class="<%=weeks[1].days[2].classname%>"><a href="#"><span><%=weeks[1].days[2].text%></span></a></td>',
                    '<td class="<%=weeks[1].days[3].classname%>"><a href="#"><span><%=weeks[1].days[3].text%></span></a></td>',
                    '<td class="<%=weeks[1].days[4].classname%>"><a href="#"><span><%=weeks[1].days[4].text%></span></a></td>',
                    '<td class="<%=weeks[1].days[5].classname%>"><a href="#"><span><%=weeks[1].days[5].text%></span></a></td>',
                    '<td class="<%=weeks[1].days[6].classname%>"><a href="#"><span><%=weeks[1].days[6].text%></span></a></td>',
                    '</tr>',
                    '<tr>',
                    '<td class="<%=weeks[2].days[0].classname%>"><a href="#"><span><%=weeks[2].days[0].text%></span></a></td>',
                    '<td class="<%=weeks[2].days[1].classname%>"><a href="#"><span><%=weeks[2].days[1].text%></span></a></td>',
                    '<td class="<%=weeks[2].days[2].classname%>"><a href="#"><span><%=weeks[2].days[2].text%></span></a></td>',
                    '<td class="<%=weeks[2].days[3].classname%>"><a href="#"><span><%=weeks[2].days[3].text%></span></a></td>',
                    '<td class="<%=weeks[2].days[4].classname%>"><a href="#"><span><%=weeks[2].days[4].text%></span></a></td>',
                    '<td class="<%=weeks[2].days[5].classname%>"><a href="#"><span><%=weeks[2].days[5].text%></span></a></td>',
                    '<td class="<%=weeks[2].days[6].classname%>"><a href="#"><span><%=weeks[2].days[6].text%></span></a></td>',
                    '</tr>',
                    '<tr>',
                    '<td class="<%=weeks[3].days[0].classname%>"><a href="#"><span><%=weeks[3].days[0].text%></span></a></td>',
                    '<td class="<%=weeks[3].days[1].classname%>"><a href="#"><span><%=weeks[3].days[1].text%></span></a></td>',
                    '<td class="<%=weeks[3].days[2].classname%>"><a href="#"><span><%=weeks[3].days[2].text%></span></a></td>',
                    '<td class="<%=weeks[3].days[3].classname%>"><a href="#"><span><%=weeks[3].days[3].text%></span></a></td>',
                    '<td class="<%=weeks[3].days[4].classname%>"><a href="#"><span><%=weeks[3].days[4].text%></span></a></td>',
                    '<td class="<%=weeks[3].days[5].classname%>"><a href="#"><span><%=weeks[3].days[5].text%></span></a></td>',
                    '<td class="<%=weeks[3].days[6].classname%>"><a href="#"><span><%=weeks[3].days[6].text%></span></a></td>',
                    '</tr>',
                    '<tr>',
                    '<td class="<%=weeks[4].days[0].classname%>"><a href="#"><span><%=weeks[4].days[0].text%></span></a></td>',
                    '<td class="<%=weeks[4].days[1].classname%>"><a href="#"><span><%=weeks[4].days[1].text%></span></a></td>',
                    '<td class="<%=weeks[4].days[2].classname%>"><a href="#"><span><%=weeks[4].days[2].text%></span></a></td>',
                    '<td class="<%=weeks[4].days[3].classname%>"><a href="#"><span><%=weeks[4].days[3].text%></span></a></td>',
                    '<td class="<%=weeks[4].days[4].classname%>"><a href="#"><span><%=weeks[4].days[4].text%></span></a></td>',
                    '<td class="<%=weeks[4].days[5].classname%>"><a href="#"><span><%=weeks[4].days[5].text%></span></a></td>',
                    '<td class="<%=weeks[4].days[6].classname%>"><a href="#"><span><%=weeks[4].days[6].text%></span></a></td>',
                    '</tr>',
                    '<tr>',
                    '<td class="<%=weeks[5].days[0].classname%>"><a href="#"><span><%=weeks[5].days[0].text%></span></a></td>',
                    '<td class="<%=weeks[5].days[1].classname%>"><a href="#"><span><%=weeks[5].days[1].text%></span></a></td>',
                    '<td class="<%=weeks[5].days[2].classname%>"><a href="#"><span><%=weeks[5].days[2].text%></span></a></td>',
                    '<td class="<%=weeks[5].days[3].classname%>"><a href="#"><span><%=weeks[5].days[3].text%></span></a></td>',
                    '<td class="<%=weeks[5].days[4].classname%>"><a href="#"><span><%=weeks[5].days[4].text%></span></a></td>',
                    '<td class="<%=weeks[5].days[5].classname%>"><a href="#"><span><%=weeks[5].days[5].text%></span></a></td>',
                    '<td class="<%=weeks[5].days[6].classname%>"><a href="#"><span><%=weeks[5].days[6].text%></span></a></td>',
                    '</tr>',
                    '</tbody>'
                ],
                months: [
                    '<tbody class="<%=className%>">',
                    '<tr>',
                    '<td colspan="2"><a href="#"><span><%=data[0]%></span></a></td>',
                    '<td colspan="2"><a href="#"><span><%=data[1]%></span></a></td>',
                    '<td colspan="2"><a href="#"><span><%=data[2]%></span></a></td>',
                    '<td colspan="1"><a href="#"><span><%=data[3]%></span></a></td>',
                    '</tr>',
                    '<tr>',
                    '<td colspan="2"><a href="#"><span><%=data[4]%></span></a></td>',
                    '<td colspan="2"><a href="#"><span><%=data[5]%></span></a></td>',
                    '<td colspan="2"><a href="#"><span><%=data[6]%></span></a></td>',
                    '<td colspan="1"><a href="#"><span><%=data[7]%></span></a></td>',
                    '</tr>',
                    '<tr>',
                    '<td colspan="2"><a href="#"><span><%=data[8]%></span></a></td>',
                    '<td colspan="2"><a href="#"><span><%=data[9]%></span></a></td>',
                    '<td colspan="2"><a href="#"><span><%=data[10]%></span></a></td>',
                    '<td colspan="1"><a href="#"><span><%=data[11]%></span></a></td>',
                    '</tr>',
                    '</tbody>'
                ],
                filters: [
                    '<div class="compare">',
                    '<div class="">',
                    '<div class="">',
                    '<form class="form-horizontal">',
                    '<div class="form-group flex justify-content-between">',
                    '<label class="col-6 px-0 control-label"><%=dateRange%></label > ',
                    '<div class="col-6 px-0 pl-1">',
                    '<select class="form-control" data-id="datedistance">',
                    '<option value="0"><%=droption0%></option>',
                    // '<option value="1" disabled><%=droption1%></option>',   //today
                    '<option value="2"><%=droption2%></option>',       //yesetrday
                    '<option value="3"><%=droption3%></option>',       //lastweek
                    //'<option value="4"><%=droption4%></option>',      
                    '<option value="5"><%=droption5%></option>',           //last month
                    '<option value="6"><%=droption6%></option>',           //last 7 days
                    '<option value="7"><%=droption7%></option>',           //last 30 days
                    //'<option value="8"><%=droption8%></option>',
                    //'<option value="9"><%=droption9%></option>',
                    //'<option value="10"><%=droption10%></option>',
                    //'<option value="11"><%=droption11%></option>',
                    //'<option value="12"><%=droption12%></option>',
                    '</select>',
                    '</div>',
                    '</div>',

                    '<div class="form-group flex justify-content-between" data-id="firstinputgroup">',
                    '<div class="col-xs-6 pr-1">',
                    '<input class="form-control" data-id="date1s" placeholder="" type="text" />',
                    '</div>',
                    '<div class="col-xs-6 pl-1">',
                    '<input class="form-control" data-id="date1e" placeholder="" type="text" />',
                    '</div>',
                    '</div>',

                    '<div class="form-group flex justify-content-between">',
                    '<div class="col-6 text-left px-0">',
                    '<div class="form-check">',
                    '<input type="checkbox" class="form-check-input" data-id="chkcompare"/>',
                    '<label data-click="free" class="form-check-label pt-1"><%=comparewith%></label>',
                    '</div>',
                    '</div>',
                    '<div class="col-6 px-0 pl-1">',
                    '<select class="form-control" data-id="selectcompare" disabled>',
                    '<option value="0"><%=croption0%></option>',
                    '<option value="1"><%=croption1%></option>',
                    '<option value="2"><%=croption2%></option>',
                    '</select>',
                    '</div>',
                    '</div>',

                    '<div class="form-group flex" data-id="secondinputgroup" style="display:none">',
                    '<div class="col-xs-6 pr-1">',
                    '<input class="form-control disabled" data-id="date2s" placeholder="" type="text"/>',
                    '</div>',
                    '<div class="col-xs-6 pl-1">',
                    '<input class="form-control disabled" data-id="date2e" placeholder="" type="text"/>',
                    '</div>',
                    '</div>',

                    '<hr />',
                    '<div class="form-group flex justify-content-between">',
                    '<div class="col-xs-12">',
                    '<button type="button" class="btn btn-warning" data-id="btnapply"><%=apply%></button><button type="button" data-id="btncancel" class="btn btn-link"><%=cancel%></button>',
                    '</div>',
                    '</div>',
                    '</form>',
                    '</div>',
                    '</div>',
                    '</div>'
                ]
            },
            defaults = {
                /* 
                 * The currently selected date(s).  This can be: a single date, an array 
                 * of two dates (sets a range when 'mode' is 'range'), or an array of
                 * any number of dates (selects all dates when 'mode' is 'multiple'.  
                 * The supplied dates can be any one of: Date object, milliseconds 
                 * (as from date.getTime(), date.valueOf()), or a date string 
                 * parseable by Date.parse().
                 */
                selectFutureDay: !1,
                selectDisableDay: !1,
                date: null,
                date2: null,
                comparable: !1,    /// comparison ormunu göster/göterme
                compareWith: !1,
                indicator: 0,  /// 0 => 1.date range cursor, 1=> 2.date range cursor aktif..
                instanlyApply: !1,
                /* 
                 * Optional date which determines the current calendar month/year.  This
                 * can be one of: Date object, milliseconds (as from date.getTime(), date.valueOf()), or a date string 
                 * parseable by Date.parse().  Defaults to todays date.
                 */
                current: null,
                /* 
                 * true causes the datepicker calendar to be appended to the DatePicker 
                 * element and rendered, false binds the DatePicker to an event on the trigger element
                 */
                inline: false,
                /* 
                 * Date selection mode, one of 'single', 'range' or 'multiple'.  Default 
                 * 'single'.  'Single' allows the selection of a single date, 'range'
                 * allows the selection of range of dates, and 'multiple' allows the 
                 * selection of any number of individual dates.
                 */
                mode: 'single',
                /* 
                 * Number of side-by-side calendars, defaults to 1.
                 */
                calendars: 1,
                /* 
                 * The day that starts the week, where 0: Sunday, 1: Monday, 2: Tuesday, 3: Wednesday, 4: Thursday, 5: Friday, 6: Saturday.  Defaults to Sunday
                 */
                starts: 0,
                /* 
                 * Previous link text.  Default '&#9664;' (Unicode left arrow)
                 */
                prev: '&#9664;',
                /* 
                 * Next link text.  Default '&#9664;' (Unicode left arrow)
                 */
                next: '&#9654;',
                /* 
                 * Initial calendar view, one of 'days', 'months' or 'years'.  Defaults to 'days'.
                 */
                view: 'days',
                /* 
                 * Date picker's position relative to the trigger element (non inline 
                 * mode only), one of 'top', 'left', 'right' or 'bottom'. Defaults to 'bottom'
                 */
                position: 'bottom',
                /* 
                 * The trigger event used to show a non-inline calendar.  Defaults to
                 * 'focus' which is useful when the trigger element is a text input, 
                 * can also be 'click' for instance if the trigger element is a button
                 * or some text element. 
                 */
                showOn: 'focus',
                /* 
                 * Callback, invoked prior to the rendering of each date cell, which 
                 * allows control of the styling of the cell via the returned hash.
                 * 
                 * @param HTMLDivElement el the datepicker containing element, ie the 
                 *        div with class 'datepicker'
                 * @param Date date the date that will be rendered
                 * @return hash with the following optional attributes:
                 *         selected: if true, date will be selected
                 *         disabled: if true, date cell will be disabled
                 *         className: css class name to add to the cell
                 */
                onRenderCell: function () { return {} },
                /* 
                 * Callback, invoked when a date is selected, with 'this' referring to
                 * the HTMLElement that DatePicker was invoked upon.
                 * 
                 * @param dates: Selected date(s) depending on calendar mode.  When calendar mode  is 'single' this
                 *        is a single Date object.  When calendar mode is 'range', this is an array containing 
                 *        a 'from' and 'to' Date objects.  When calendar mode is 'multiple' this is an array
                 *        of Date objects.
                 * @param HTMLElement el the DatePicker element, ie the element that DatePicker was invoked upon
                 */
                onChange: function () { },
                /* 
                 * Invoked before a non-inline datepicker is shown, with 'this'
                 * referring to the HTMLElement that DatePicker was invoked upon, ie
                 * the trigger element
                 * 
                 * @param HTMLDivElement el The datepicker container element, ie the div with class 'datepicker'
                 * @return true to allow the datepicker to be shown, false to keep it hidden
                 */
                onBeforeShow: function () { return true },
                /* 
                 * Invoked after a non-inline datepicker is shown, with 'this'
                 * referring to the HTMLElement that DatePicker was invoked upon, ie
                 * the trigger element
                 * 
                 * @param HTMLDivElement el The datepicker container element, ie the div with class 'datepicker'
                 */
                onAfterShow: function () { },
                /* 
                 * Invoked before a non-inline datepicker is hidden, with 'this'
                 * referring to the HTMLElement that DatePicker was invoked upon, ie
                 * the trigger element
                 * 
                 * @param HTMLDivElement el The datepicker container element, ie the div with class 'datepicker'
                 * @return true to allow the datepicker to be hidden, false to keep it visible
                 */
                onBeforeHide: function () { return true },
                /* 
                 * Invoked after a non-inline datepicker is hidden, with 'this'
                 * referring to the HTMLElement that DatePicker was invoked upon, ie
                 * the trigger element
                 * 
                 * @param HTMLDivElement el The datepicker container element, ie the div with class 'datepicker'
                 */
                onAfterHide: function () { },
                /* 
                 * Locale text for day/month names: provide a hash with keys 'daysMin', 'months' and 'monthsShort'. Default english 
                 */
                language: "en",
                locale: {
                    daysMin: ["S", "M", "T", "W", "T", "F", "S"],
                    months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    filterWords: {
                        dateRange: "Date Range",
                        choose: "Customize",
                        today: "Today",
                        yesterday: "Yesterday",
                        lastWeek: "Last Week",
                        last2Weeks: "Last 2 weeks",
                        lastMonth: "Last Month",
                        last7Days: "Last 7 Days",
                        last30Days: "Last 30 Days",
                        last4Months: "Last 4 Months",
                        last5Months: "Last 5 Months",
                        last6Months: "Last 6 Months",
                        last7Months: "Last 7 Months",
                        lastYear: "Last Year",
                        compareWith: "Compare with",
                        previousSeason: "Previous period",
                        previousYear: "Last year",
                        apply: "Apply",
                        cancel: "cancel"
                    }
                },
                /* 
                 * The combined height from the top/bottom borders.  'false' is the default
                 * and generally the correct value.
                 */
                extraHeight: false,
                /* 
                 * The combined width from the left/right borders.  'false' is the default
                 * and generally the correct value.
                 */
                extraWidth: false,
                /* 
                 * Private option, used to determine when a range is selected
                 */
                lastSel: false
            },

            /* 
             * Internal method which renders the calendar cells
             * 
             * @param HTMLDivElement el datepicker container element
             */
            fill = function (el) {

                var options = $(el).data('datepicker');

                var cal = $(el);
                var currentCal = Math.floor(options.calendars / 2), date, data, dow, month, cnt = 0, days, indic, indic2, html, tblCal;

                cal.find('td>table tbody').remove();
                for (var i = 0; i < options.calendars; i++) {
                    date = new Date(options.current);
                    date.addMonths(-currentCal + i);
                    tblCal = cal.find('table').eq(i + 1);

                    if (i == 0) tblCal.addClass('datepickerFirstView');
                    if (i == options.calendars - 1) tblCal.addClass('datepickerLastView');

                    if (tblCal.hasClass('datepickerViewDays')) {
                        dow = date.getMonthName(true) + ", " + date.getFullYear();
                    } else if (tblCal.hasClass('datepickerViewMonths')) {
                        dow = date.getFullYear();
                    } else if (tblCal.hasClass('datepickerViewYears')) {
                        dow = (date.getFullYear() - 6) + ' - ' + (date.getFullYear() + 5);
                    }
                    tblCal.find('thead tr:first th a:eq(1) span').text(dow);
                    dow = date.getFullYear() - 6;
                    data = {
                        data: [],
                        className: 'datepickerYears'
                    };
                    for (var j = 0; j < 12; j++) {
                        data.data.push(dow + j);
                    }
                    /* datepickerYears template*/
                    html = tmpl(tpl.months.join(''), data);
                    date.setDate(1);
                    data = { weeks: [], test: 10 };
                    month = date.getMonth();
                    dow = (date.getDay() - options.starts) % 7;
                    date.addDays(-(dow + (dow < 0 ? 7 : 0)));
                    cnt = 0;
                    while (cnt < 42) {
                        indic = parseInt(cnt / 7, 10);
                        indic2 = cnt % 7;
                        if (!data.weeks[indic]) {
                            data.weeks[indic] = {
                                days: []
                            };
                        }
                        data.weeks[indic].days[indic2] = {
                            text: date.getDate(),
                            classname: []
                        };
                        var today = new Date();
                        if (today.getDate() == date.getDate() && today.getMonth() == date.getMonth() && today.getYear() == date.getYear()) {
                            data.weeks[indic].days[indic2].classname.push('datepickerToday');
                        }
                        if (date > today) {
                            // current month, date in future
                            data.weeks[indic].days[indic2].classname.push('datepickerFuture');
                        }

                        if (month != date.getMonth()) {
                            data.weeks[indic].days[indic2].classname.push('datepickerNotInMonth');
                            // disable clicking of the 'not in month' cells
                            data.weeks[indic].days[indic2].classname.push('datepickerDisabled');
                        }
                        if (date.getDay() == 0) {
                            data.weeks[indic].days[indic2].classname.push('datepickerSunday');
                        }
                        if (date.getDay() == 6) {
                            data.weeks[indic].days[indic2].classname.push('datepickerSaturday');
                        }

                        var fromUser = options.onRenderCell(el, date);

                        var val = date.valueOf();

                        if (options.date && (!$.isArray(options.date) || options.date.length > 0)) {
                            if (fromUser.selected || options.date == val || $.inArray(val, options.date) > -1
                                || (options.mode == 'range' && val >= options.date[0] && val <= options.date[1])) {
                                data.weeks[indic].days[indic2].classname.push('datepickerSelected');
                            }
                        }

                        ///// compare begin
                        if (options.compareWith) {// && options.indicator == 1) {
                            if (options.date2 && (!$.isArray(options.date2) || options.date2.length > 0)) {
                                if (fromUser.selected || options.date2 == val || $.inArray(val, options.date2) > -1
                                    || (options.mode == 'range' && val >= options.date2[0] && val <= options.date2[1])) {
                                    data.weeks[indic].days[indic2].classname.push('datepickerSelected2');
                                }
                            }
                        }
                        ////// compare end 
                        if (fromUser.disabled) {
                            data.weeks[indic].days[indic2].classname.push('datepickerDisabled');
                        }
                        if (fromUser.className) {
                            data.weeks[indic].days[indic2].classname.push(fromUser.className);
                        }
                        data.weeks[indic].days[indic2].classname = data.weeks[indic].days[indic2].classname.join(' ');
                        cnt++;
                        date.addDays(1);
                    }
                    // Fill the datepickerDays template with data
                    html = tmpl(tpl.days.join(''), data) + html;

                    data = {
                        data: options.locale.monthsShort,
                        className: 'datepickerMonths'
                    };
                    // datepickerMonths template
                    html = tmpl(tpl.months.join(''), data) + html;

                    tblCal.append(html);
                }

                //tblCal = cal.find('table').eq();
                //tblCal.append(tpl.filters.join(''));
                if (options.comparable) {
                    var input_group_1 = { el1: $(el).find(".compare").find("input[data-id='date1s']"), date1: new Date(options.date[0]), el2: $(el).find(".compare").find("input[data-id='date1e']"), date2: new Date(options.date[1]) };
                    input_group_1.el1.val(input_group_1.date1.getDate() + ' ' + input_group_1.date1.getMonthName(false) + ', ' + input_group_1.date1.getFullYear());
                    input_group_1.el2.val(input_group_1.date2.getDate() + ' ' + input_group_1.date2.getMonthName(false) + ', ' + input_group_1.date2.getFullYear());

                    if (options.compareWith) {
                        var input_group_2 = { el1: $(el).find(".compare").find("input[data-id='date2s']"), date1: new Date(options.date2[0]), el2: $(el).find(".compare").find("input[data-id='date2e']"), date2: new Date(options.date2[1]) };
                        input_group_2.el1.val(input_group_2.date1.getDate() + ' ' + input_group_2.date1.getMonthName(false) + ', ' + input_group_2.date1.getFullYear());
                        input_group_2.el2.val(input_group_2.date2.getDate() + ' ' + input_group_2.date2.getMonthName(false) + ', ' + input_group_2.date2.getFullYear());
                    }
                }
            },

            /*
              Extends the Date object with some useful helper methods
            */
            extendDate = function (locale) {
                if (Date.prototype.tempDate) {
                    return;
                }
                Date.prototype.tempDate = null;
                Date.prototype.months = locale.months;
                Date.prototype.filterWords = locale.filterWords;
                Date.prototype.monthsShort = locale.monthsShort;
                Date.prototype.getMonthName = function (fullName) {
                    return this[fullName ? 'months' : 'monthsShort'][this.getMonth()];
                };
                Date.prototype.addDays = function (n) {
                    this.setDate(this.getDate() + n);
                    this.tempDate = this.getDate();
                };
                Date.prototype.addMonths = function (n) {
                    if (this.tempDate == null) {
                        this.tempDate = this.getDate();
                    }
                    this.setDate(1);
                    this.setMonth(this.getMonth() + n);
                    this.setDate(Math.min(this.tempDate, this.getMaxDays()));
                };
                Date.prototype.addYears = function (n) {
                    if (this.tempDate == null) {
                        this.tempDate = this.getDate();
                    }
                    this.setDate(1);
                    this.setFullYear(this.getFullYear() + n);
                    this.setDate(Math.min(this.tempDate, this.getMaxDays()));
                };
                Date.prototype.getMaxDays = function () {
                    var tmpDate = new Date(Date.parse(this)),
                        d = 28, m;
                    m = tmpDate.getMonth();
                    d = 28;
                    while (tmpDate.getMonth() == m) {
                        d++;
                        tmpDate.setDate(d);
                    }
                    return d - 1;
                };
            },

            /* 
             * Internal method which lays out the calendar widget
             */
            layout = function (el) {
                var options = $(el).data('datepicker');
                var cal = $('#' + options.id);
                if (options.extraHeight === false) {
                    var divs = $(el).find('div');
                    options.extraHeight = divs.get(0).offsetHeight + divs.get(1).offsetHeight;  // heights from top/bottom borders
                    options.extraWidth = divs.get(2).offsetWidth + divs.get(3).offsetWidth;     // widths from left/right borders
                }
                var tbl = cal.find('table:first').get(0);
                var width = tbl.offsetWidth + 20;
                var height = tbl.offsetHeight + 40;
                cal.css({
                    width: width + options.extraWidth + 'px',
                    height: height + options.extraHeight + 'px'
                }).find('div.datepickerContainer').css({
                    width: width + 'px',
                    height: height + 'px'
                });
            },
            /*fixedSelectBoxToZero = function (el) {
                let mform = $(el).find(".compare");
                let s1 = mform.find("[data-id='datedistance']");
                let s2 = mform.find("[data-id='selectcompare']");

            },*/
            dayCountBetween2dates = function (date1, date2) {
                dt1 = new Date(date1);
                dt2 = new Date(date2);
                return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate())) / (1000 * 60 * 60 * 24));
            },
            changeCompare = function () {
                var options = $(this).data('datepicker');
                let so = $(this).is(":checked");
                let selectcompare = $(this).closest(".compare").find("[data-id='selectcompare']");
                let inputgroup2 = $(this).closest(".compare").find("[data-id='secondinputgroup']");

                if (!so) {
                    $(selectcompare).attr("disabled", "disabled");
                    $(inputgroup2).find("input").addClass("disabled");
                    $(inputgroup2).hide();

                    options.compareWith = !1;
                    options.indicator = 0;
                    setDates($("#" + options.id), options.date, null, true);

                }
                else {
                    $(selectcompare).removeAttr("disabled");
                    $(inputgroup2).show();
                    $(selectcompare).val(1).trigger('change');
                    $(inputgroup2).find("input").removeClass("disabled");
                    options.compareWith = !0;
                    options.indicator = 1;
                    setDates($("#" + options.id), null, options.date2, true);

                }
            },

            changeOption = function () {
                var options = $(this).data('datepicker');
                let so = $(this).find("option:selected");
                let inputgroup1 = $(this).closest(".compare").find("[data-id='firstinputgroup']");
                var nd = [new Date(), new Date()];

                $(inputgroup1).find("input").addClass("disabled");

                switch (parseFloat($(so).val())) {
                    case 0:     //özel
                        //nd = options.date;
                        //inputgroup1.show();
                        $(inputgroup1).find("input").removeClass("disabled");

                        break;
                    case 1:     //bugun
                        //inputgroup1.hide();

                        break;
                    case 2:     //dün
                        nd[0].addDays(-1);
                        nd[1].addDays(-1);

                        break;
                    case 3:     //lastweek
                        nd[0].addDays(-7);

                        break;

                    case 4:     //son 2 hafta           IPTAL
                        nd[0].addDays(-14);
                        nd[1].addDays(-7);
                        break;

                    case 5:     //last month
                        nd[0].addMonths(-2);
                        nd[1].addMonths(-1);

                        break;

                    case 6:     //last 7 days
                        nd[0].addDays(-6);
                        break;

                    case 7:     //last 30 days
                        nd[0].addDays(-29);


                        break;
                    case 8:     //son 4 ay
                        nd[0].addMonths(-4);
                        break;
                    case 9:     //son 5 ay
                        nd[0].addMonths(-5);
                        break;
                    case 10:     //son 6 ay
                        nd[0].addMonths(-6);
                        break;
                    case 11:     //son 7 ay
                        nd[0].addMonths(-7);
                        break;

                    case 12:     //geçen yıl
                        nd[0].addYears(-1);
                        break;

                }


                setDates($("#" + options.id), nd, null, true);

                /// karşılaştırma aktifse trigliyoruz
                if (options.compareWith && options.comparable) {
                    let so = $(this).closest(".compare").find("[data-id='selectcompare']");
                    so.trigger('change', false);/// shiftTo = false
                }
            },
            changeCompareOption = function (event, shiftTo = true) {
                var options = $(this).data('datepicker');
                let so = $(this).find("option:selected");
                let inputgroup2 = $(this).closest(".compare").find("[data-id='secondinputgroup']");
                var nd = [new Date(), new Date()];
                inputgroup2.show();
                options.indicator = 1;

                let d012 = [new Date(options.date[0]), new Date(options.date[1])];

                switch (parseFloat($(so).val())) {
                    case 0:     //özel
                        //d012 = [new Date(options.date2[0]), new Date(options.date2[1])];            //bunu kaldırma...
                        break;
                    case 1:     //Previous ay + aynı seçim
                        let fark = dayCountBetween2dates(options.date[0], options.date[1]);
                        //console.log("fark", fark);
                        d012[1] = new Date(options.date[0]);
                        d012[1].addDays(-1);
                        d012[0].addDays((-1 * fark) - 1);
                        break;
                    case 2:     //last year same range;
                        d012[0].addYears(-1);
                        d012[1].addYears(-1);

                        break;


                }
                nd = d012;

                setDates($("#" + options.id), null, nd, shiftTo);

            },
            setDates = function (el, date, date2, shiftTo) {
                var options = $(el).data('datepicker');
                console.log("data", date);
                if (date != null) {
                    options.date = normalizeDate(options.mode, date);

                    if (shiftTo) {
                        options.current = new Date(options.mode != 'single' ? options.date[0] : options.date);
                    }
                }
                if (date2 != null) {
                    options.date2 = normalizeDate(options.mode, date2);
                    if (shiftTo) {
                        options.current = new Date(options.mode != 'single' ? options.date2[0] : options.date2);
                    }
                }

                fill($(el).get(0));
            },
            prepareDisplayText = function (_options) {
                let _dates = prepareDate(_options)[0];
                if (_dates === null)
                    return false;
                console.log("d", _dates);
                if (_options.mode === 'single') {
                    //#region
                    let year = _dates.getFullYear();//.format('YYYY');
                    let month = ("0" + (_dates.getMonth() == 11 ? "12" : (_dates.getMonth() + 1))).slice(-2);
                    let day = ("0" + _dates.getDate()).slice(-2);
                    //#endregion
                    $(_options.el).val(day + ' ' + _dates.getMonthName(true) + ' ' + year);
                } else {
                    //#region
                    let year = _dates[0].getFullYear();
                    let month = ("0" + (_dates[0].getMonth() == 11 ? "12" : (_dates[0].getMonth() + 1))).slice(-2);
                    let day = ("0" + _dates[0].getDate()).slice(-2);

                    let endyear = _dates[1].getFullYear();
                    let endmonth = ("0" + (_dates[1].getMonth() == 11 ? "12" : (_dates[1].getMonth() + 1))).slice(-2);
                    let endday = ("0" + _dates[1].getDate()).slice(-2);
                    //#endregion
                    $(_options.el).val(day + ' ' + _dates[0].getMonthName(false) + ' ' + year + ' - ' + endday + ' ' + _dates[1].getMonthName(false) + ' ' + endyear);
                    let newel = $(_options.elwrap).get(0);
                    let clabel = $(newel).find(".compare-label");
                    if (_options.compareWith) {

                        let cvalue = ("0" + _dates[2].getDate()).slice(-2) + " " +
                            _dates[2].getMonthName(false) + " " +
                            _dates[2].getFullYear() + " - " +
                            ("0" + _dates[3].getDate()).slice(-2) + " " +
                            _dates[2].getMonthName(false) + " " +
                            _dates[3].getFullYear();

                        clabel.html(_options.locale.filterWords.compareWith + "<span>" + cvalue + "</span>");
                        clabel.show();
                    } else {
                        clabel.hide();
                    }
                }
            },
            tarihAraligi = function (el, chkbox) {
                let so = $(chkbox).find("option:selected");
                let inputgroup1 = $(chkbox).closest(".compare").find("[data-id='firstinputgroup']");
                //var opt = $(el).data('datepicker');
                //$(el).data('datepicker').date = normalizeDate(opt.mode, new Date());
                //fill($(el));
                switch (parseFloat($(so).val())) {
                    case 0:     //özel
                        inputgroup1.show();
                        break;
                    case 1:     //bugun
                        setDate(el, new Date(), true);
                        inputgroup1.hide();
                        break;
                    case 2:     //dün
                        inputgroup1.hide();
                        break;
                    case 3:     //geçen hafta
                        inputgroup1.hide();
                        break;

                }

            },

            /* 
             * Internal method, bound to the HTML DatePicker Element, onClick.
             * This is the function that controls the behavior of the calendar when
             * the title, next/previous, or a date cell is clicked on.
             */

            click = function (ev) {
                var mainparent = ev.delegateTarget;
                var compareform = $($(ev.delegateTarget).find(".compare").get(0));


                if ($(ev.target).closest(".compare").length > 0) {
                    return true;
                }

                if ($(ev.target).is('span')) {
                    ev.target = ev.target.parentNode;
                }
                if ($(ev.target).is('div')) {

                    ev.target = ev.target.parentNode;
                }

                var el = $(ev.target);

                if (el.is('a')) {
                    ev.target.blur();



                    var options = $(this).data('datepicker');
                    var parentEl = el.parent();

                    if (parentEl.hasClass('datepickerFuture') && options.selectFutureDay != true) {
                        console.log("return false");
                        return false;
                    }
                    if (parentEl.hasClass('datepickerDisabled') && options.selectDisableDay != true) {
                        console.log("return false");
                        return false;
                    }


                    var tblEl = parentEl.parent().parent().parent();
                    var tblIndex = $('table', this).index(tblEl.get(0)) - 1;
                    var tmp = new Date(options.current);
                    var changed = false;
                    var fillIt = false;
                    var currentCal = Math.floor(options.calendars / 2);

                    if (parentEl.is('th')) {
                        // clicking the calendar title

                        if (el.hasClass('datepickerMonth')) {
                            // clicking on the title of a Month Datepicker
                            tmp.addMonths(tblIndex - currentCal);

                            if (options.mode == 'range') {
                                // range, select the whole month
                                compareform.find(".focus").removeClass("focus");

                                tmp.setDate(1);
                                if (options.compareWith && options.indicator == 1) {
                                    options.date2[0] = (tmp.setHours(0, 0, 0, 0)).valueOf();
                                    tmp.addDays(tmp.getMaxDays() - 1);
                                    tmp.setHours(23, 59, 59, 0);
                                    options.date2[1] = tmp.valueOf();
                                    options.indicator = 0;
                                    compareform.find("input[data-id='date2s'],input[data-id='date2e']").addClass("focus");


                                } else {
                                    options.date[0] = (tmp.setHours(0, 0, 0, 0)).valueOf();
                                    tmp.addDays(tmp.getMaxDays() - 1);
                                    tmp.setHours(23, 59, 59, 0);
                                    options.date[1] = tmp.valueOf();
                                    options.indicator = 1;
                                    compareform.find("input[data-id='date1s'],input[data-id='date1e']").addClass("focus");

                                }
                                fillIt = true;
                                changed = true;
                                options.lastSel = false;
                            } else if (options.calendars == 1) {
                                // single/multiple mode with a single calendar: swap between daily/monthly/yearly view.
                                // Note:  there's no reason a multi-calendar widget can't have this functionality,
                                //   however I think it looks really unintuitive.
                                if (tblEl.eq(0).hasClass('datepickerViewDays')) {
                                    tblEl.eq(0).toggleClass('datepickerViewDays datepickerViewMonths');
                                    el.find('span').text(tmp.getFullYear());
                                } else if (tblEl.eq(0).hasClass('datepickerViewMonths')) {
                                    tblEl.eq(0).toggleClass('datepickerViewMonths datepickerViewYears');
                                    el.find('span').text((tmp.getFullYear() - 6) + ' - ' + (tmp.getFullYear() + 5));
                                } else if (tblEl.eq(0).hasClass('datepickerViewYears')) {
                                    tblEl.eq(0).toggleClass('datepickerViewYears datepickerViewDays');
                                    el.find('span').text(tmp.getMonthName(true) + ", " + tmp.getFullYear());
                                }
                            }
                        } else if (parentEl.parent().parent().is('thead')) {
                            // clicked either next/previous arrows
                            if (tblEl.eq(0).hasClass('datepickerViewDays')) {
                                options.current.addMonths(el.hasClass('datepickerGoPrev') ? -1 : 1);
                            } else if (tblEl.eq(0).hasClass('datepickerViewMonths')) {
                                options.current.addYears(el.hasClass('datepickerGoPrev') ? -1 : 1);
                            } else if (tblEl.eq(0).hasClass('datepickerViewYears')) {
                                options.current.addYears(el.hasClass('datepickerGoPrev') ? -12 : 12);
                            }
                            fillIt = true;
                        }

                    } else if (parentEl.is('td') && !parentEl.hasClass('datepickerDisabled')) {
                        // clicking the calendar grid

                        if (tblEl.eq(0).hasClass('datepickerViewMonths')) {
                            // clicked a month cell
                            options.current.setMonth(tblEl.find('tbody.datepickerMonths td').index(parentEl));
                            options.current.setFullYear(parseInt(tblEl.find('thead th a.datepickerMonth span').text(), 10));
                            options.current.addMonths(currentCal - tblIndex);
                            tblEl.eq(0).toggleClass('datepickerViewMonths datepickerViewDays');
                        } else if (tblEl.eq(0).hasClass('datepickerViewYears')) {
                            // clicked a year cell
                            options.current.setFullYear(parseInt(el.text(), 10));
                            tblEl.eq(0).toggleClass('datepickerViewYears datepickerViewMonths');
                        } else {
                            // clicked a day cell
                            var val = parseInt(el.text(), 10);
                            tmp.addMonths(tblIndex - currentCal);
                            if (parentEl.hasClass('datepickerNotInMonth')) {
                                tmp.addMonths(val > 15 ? -1 : 1);
                            }
                            tmp.setDate(val);
                            switch (options.mode) {
                                case 'multiple':
                                    val = (tmp.setHours(0, 0, 0, 0)).valueOf();
                                    if ($.inArray(val, options.date) > -1) {
                                        $.each(options.date, function (nr, dat) {
                                            if (dat == val) {
                                                options.date.splice(nr, 1);
                                                return false;
                                            }
                                        });
                                    } else {
                                        options.date.push(val);
                                    }
                                    break;
                                case 'range':
                                    compareform.find(".focus").removeClass("focus");
                                    if (options.compareWith && options.indicator == 1) {
                                        if (!options.lastSel) {
                                            // first click: set to the start of the day
                                            options.date2[0] = (tmp.setHours(0, 0, 0, 0)).valueOf();
                                            compareform.find("input[data-id='date2s']").addClass("focus");
                                        } else {
                                            compareform.find("input[data-id='date2e']").addClass("focus");

                                            options.indicator = 0;

                                        }
                                        // get the very end of the day clicked
                                        val = (tmp.setHours(23, 59, 59, 0)).valueOf();

                                        if (val < options.date2[0]) {
                                            // second range click < first
                                            options.date2[1] = options.date2[0] + 86399000;  // starting date + 1 day
                                            options.date2[0] = val - 86399000;  // minus 1 day
                                        } else {
                                            // initial range click, or final range click >= first
                                            options.date2[1] = val;
                                        }
                                    }
                                    else {
                                        if (!options.lastSel) {
                                            // first click: set to the start of the day
                                            options.date[0] = (tmp.setHours(0, 0, 0, 0)).valueOf();
                                            compareform.find("input[data-id='date1s']").addClass("focus");
                                        } else {
                                            compareform.find("input[data-id='date1e']").addClass("focus");
                                            if (options.compareWith) {
                                                options.indicator = 1;
                                            }
                                        }
                                        // get the very end of the day clicked
                                        val = (tmp.setHours(23, 59, 59, 0)).valueOf();

                                        if (val < options.date[0]) {
                                            // second range click < first
                                            options.date[1] = options.date[0] + 86399000;  // starting date + 1 day
                                            options.date[0] = val - 86399000;  // minus 1 day
                                        } else {
                                            // initial range click, or final range click >= first
                                            options.date[1] = val;
                                        }
                                    }

                                    options.lastSel = !options.lastSel;
                                    break;
                                default:

                                    options.date = tmp.valueOf();
                                    break;
                            }
                            changed = true;
                        }
                        fillIt = true;
                    }

                    if (fillIt) {
                        if (options.indicator == 0) {
                            let inputgroup = compareform.find("[data-id='firstinputgroup']").get(0);
                            $(inputgroup).find("input").removeClass("disabled");
                            let s1 = compareform.find("[data-id='datedistance']").get(0);
                            $(s1).val(0);//.trigger("change");

                        } else {
                            let inputgroup = compareform.find("[data-id='secondinputgroup']").get(0);
                            $(inputgroup).find("input").removeClass("disabled");

                            let s2 = compareform.find("[data-id='selectcompare']").get(0);
                            $(s2).val(0);//.trigger("change");
                        }
                        fill(this);
                    }
                    if (changed && options.instanlyApply) {
                        options.onChange.apply(this, prepareDate(options));
                        //console.log("options.lastSel", options.lastSel);
                        if (!options.lastSel) {
                            prepareDisplayText(options);
                            $(this).hide();
                        }
                    }
                }
                return false;
            },

            /* 
             * Internal method, called from the public getDate() method, and when
             * invoking the onChange callback function
             * 
             * @param object options with the following attributes: 'mode' which can
             *        be one of 'single', 'range', or 'multiple'.  Attribute 'date'
             *        which will be a single timestamp when 'mode' is 'single', or
             *        an array of timestamps otherwise.  Attribute 'el' which is the
             *        HTML element that DatePicker was invoked upon.
             * @return array where the first item is either a Date object, or an 
             *         array of Date objects, depending on the DatePicker mode, and
             *         the second item is the HTMLElement that DatePicker was invoked
             *         upon.
             */
            prepareDate = function (options) {
                var dates = null;
                if (options.mode == 'single') {
                    if (options.date) dates = new Date(options.date);
                } else {
                    dates = new Array();
                    $(options.date).each(function (i, val) {
                        dates.push(new Date(val));
                    });
                    $(options.date2).each(function (i, val) {
                        dates.push(new Date(val));
                    });

                }
                return [dates, options.el, options.compareWith];
            },

            /* 
             * Internal method, returns an object containing the viewport dimensions
             */
            getViewport = function () {
                var m = document.compatMode == 'CSS1Compat';
                return {
                    l: window.pageXOffset || (m ? document.documentElement.scrollLeft : document.body.scrollLeft),
                    t: window.pageYOffset || (m ? document.documentElement.scrollTop : document.body.scrollTop),
                    w: window.innerWidth || (m ? document.documentElement.clientWidth : document.body.clientWidth),
                    h: window.innerHeight || (m ? document.documentElement.clientHeight : document.body.clientHeight)
                };
            },

            /* 
             * Internal method, returns true if el is a child of parentEl
             */
            isChildOf = function (parentEl, el, container) {
                if (parentEl == el) {
                    return true;
                }
                if (parentEl.contains) {
                    return parentEl.contains(el);
                }
                if (parentEl.compareDocumentPosition) {
                    return !!(parentEl.compareDocumentPosition(el) & 16);
                }
                var prEl = el.parentNode;
                while (prEl && prEl != container) {
                    if (prEl == parentEl)
                        return true;
                    prEl = prEl.parentNode;
                }
                return false;
            },

            /* 
             * Bound to the HTML DatePicker element when it's not inline, and also 
             * can be called directly to show the bound datepicker.  A DatePicker
             * calendar shown with this method will hide on a mouseclick outside
             * of the calendar.
             * 
             * Method is not applicable for inline DatePickers
             */
            show = function (ev) {
                var cal = $('#' + $(this).data('datepickerId'));
                if (!cal.is(':visible')) {
                    var calEl = cal.get(0);
                    var options = cal.data('datepicker');



                    var test = options.onBeforeShow.apply(this, [calEl]);
                    if (options.onBeforeShow.apply(this, [calEl]) == false) {
                        return;
                    }

                    fill(calEl);
                    let newel = $(options.elwrap).get(0);
                    console.log("vv", newel);
                    var pos = $(newel).offset();//$(this).offset();
                    var viewPort = getViewport();
                    var top = pos.top;
                    var left = pos.left;
                    var oldDisplay = $.curCSS(calEl, 'display');
                    cal.css({
                        visibility: 'hidden',
                        display: 'block'
                    });
                    layout(calEl);

                    switch (options.position) {
                        case 'top':
                            top -= newel.offsetHeight;
                            break;
                        case 'left':
                            left -= calEl.offsetWidth;
                            break;
                        case 'right':
                            left += newel.offsetWidth;
                            break;
                        case 'bottom':
                            top += newel.offsetHeight;
                            break;
                    }
                    if (top + calEl.offsetHeight > viewPort.t + viewPort.h) {
                        top = pos.top - calEl.offsetHeight;
                    }
                    if (top < viewPort.t) {
                        top = pos.top + newel.offsetHeight + calEl.offsetHeight;
                    }
                    if (left + calEl.offsetWidth > viewPort.l + viewPort.w) {
                        left = pos.left - calEl.offsetWidth;

                    }

                    if (left < viewPort.l) {
                        left = pos.left;// + this.offsetWidth

                    }

                    cal.css({
                        visibility: 'visible',
                        display: 'block',
                        top: top + 'px',
                        left: left + 'px'
                    });
                    options.onAfterShow.apply(this, [cal.get(0)]);
                    $(document).bind('mousedown', { cal: cal, trigger: this }, hide);  // global listener so clicking outside the calendar will close it

                }
                return false;
            },

            /* 
             * Hide a non-inline DatePicker calendar.
             * 
             * Not applicable for inline DatePickers.
             * 
             * @param ev Event object
             */
            hide = function (ev) {
                if (ev.target != ev.data.trigger && !isChildOf(ev.data.cal.get(0), ev.target, ev.data.cal.get(0))) {
                    if (ev.data.cal.data('datepicker').onBeforeHide.apply(this, [ev.data.cal.get(0)]) != false) {
                        ev.data.cal.hide();
                        ev.data.cal.data('datepicker').onAfterHide.apply(this, [ev.data.cal.get(0)]);
                        $(document).unbind('mousedown', hide);  // remove the global listener
                    }
                }
            },

            /* 
             * Internal method to normalize the selected date based on the current 
             * calendar mode.
             */
            normalizeDate = function (mode, date) {
                // if range/multi mode, make sure that the current date value is at least an empty array
                if (mode != 'single' && !date) date = [];

                // if we have a selected date and not a null or empty array
                if (date && (!$.isArray(date) || date.length > 0)) {
                    // Create a standardized date depending on the calendar mode
                    if (mode != 'single') {
                        if (!$.isArray(date)) {
                            date = [((new Date(date)).setHours(0, 0, 0, 0)).valueOf()];
                            if (mode == 'range') {
                                // create a range of one day
                                date.push(((new Date(date[0])).setHours(23, 59, 59, 0)).valueOf());
                            }
                        } else {
                            for (var i = 0; i < date.length; i++) {
                                date[i] = ((new Date(date[i])).setHours(0, 0, 0, 0)).valueOf();
                            }
                            if (mode == 'range') {
                                // for range mode, create the other end of the range
                                if (date.length == 1) date.push(new Date(date[0]));
                                date[1] = ((new Date(date[1])).setHours(23, 59, 59, 0)).valueOf();
                            }
                        }
                    } else {
                        // mode is single, convert date object into a timestamp
                        date = ((new Date(date)).setHours(0, 0, 0, 0)).valueOf();
                    }
                    // at this point date is either a timestamp at hour zero 
                    //  for 'single' mode, an array of timestamps at hour zero for 
                    //  'multiple' mode, or a two-item array with timestamps at hour
                    //  zero and hour 23:59 for 'range' mode
                }
                return date;
            };
        return {
            /* 
             * 'Public' functions
             */

            /* 
             * Called when element.DatePicker() is invoked
             * 
             * Note that 'this' is the HTML element that DatePicker was invoked upon
             * @see DatePicker()
             */
            init: function (options) {
                options = $.extend({}, defaults, options || {});
                if (options.language == "tr") {
                    options.locale = turkishlocale();
                }
                extendDate(options.locale);
                options.calendars = Math.max(1, parseInt(options.calendars, 10) || 1);
                options.mode = /single|multiple|range/.test(options.mode) ? options.mode : 'single';

                return this.each(function () {
                    if (!$(this).data('datepicker')) {
                        $(this).attr("readonly", "readonly");
                        let ew = document.createElement("div");
                        $(ew).addClass("drp-wrap");

                        this.parentNode.insertBefore(ew, this);
                        $(this).appendTo($(ew));
                        options.elwrap = $(ew);
                        options.el = this;
                        $(ew).append("<div class='compare-label'></div>");


                        options.date = normalizeDate(options.mode, options.date);

                        if (!options.current) {
                            options.current = new Date();
                        } else {
                            options.current = new Date(options.current);
                        }
                        options.current.setDate(1);
                        options.current.setHours(0, 0, 0, 0);

                        var id = 'datepicker_' + parseInt(Math.random() * 1000), cnt;
                        options.id = id;
                        $(this).data('datepickerId', options.id);
                        var cal = $(tpl.wrapper).attr('id', id).bind('click', click).data('datepicker', options);

                        if (options.className) {
                            cal.addClass(options.className);
                        }
                        var html = '';
                        for (var i = 0; i < options.calendars; i++) {
                            cnt = options.starts;
                            if (i > 0) {
                                html += tpl.space;
                            }
                            // calendar header template
                            html += tmpl(tpl.head.join(''), {
                                prev: options.prev,
                                next: options.next,
                                day1: options.locale.daysMin[(cnt++) % 7],
                                day2: options.locale.daysMin[(cnt++) % 7],
                                day3: options.locale.daysMin[(cnt++) % 7],
                                day4: options.locale.daysMin[(cnt++) % 7],
                                day5: options.locale.daysMin[(cnt++) % 7],
                                day6: options.locale.daysMin[(cnt++) % 7],
                                day7: options.locale.daysMin[(cnt++) % 7]
                            });

                        }

                        cal.find('tr:first').append(html).find('table').addClass(views[options.view]);


                        if (options.comparable) {
                            // here

                            html = tmpl(tpl.filters.join(''), {
                                dateRange: options.locale.filterWords.dateRange,
                                droption0: options.locale.filterWords.choose,
                                droption1: options.locale.filterWords.today,
                                droption2: options.locale.filterWords.yesterday,
                                droption3: options.locale.filterWords.lastWeek,
                                // droption4: options.locale.filterWords.last2Weeks,
                                droption5: options.locale.filterWords.lastMonth,
                                droption6: options.locale.filterWords.last7Days,
                                droption7: options.locale.filterWords.last30Days,
                                //droption8: options.locale.filterWords.last4Months,
                                //droption9: options.locale.filterWords.last5Months,
                                //droption10: options.locale.filterWords.last6Months,
                                //droption11: options.locale.filterWords.last7Months,
                                //droption12: options.locale.filterWords.lastYear,
                                comparewith: options.locale.filterWords.compareWith,
                                croption0: options.locale.filterWords.choose,
                                croption1: options.locale.filterWords.previousSeason,
                                croption2: options.locale.filterWords.previousYear,
                                apply: options.locale.filterWords.apply,
                                cancel: options.locale.filterWords.cancel
                            });
                            cal.find('tr:first').prepend("<td valign='top'>" + html + "</td>");

                            //var comparisions = $("#comparisions").html();
                            // cal.find('tr:first').prepend("<td valign='top'>" + html + "</td>");

                            //          tarih aralığı electboxunu bind etti
                            let datedistance = cal.find("[data-id='datedistance']").get(0);
                            $(datedistance).bind('change', changeOption).data('datepicker', options);

                            //          şunun la karşılaştır  checkboxunu bind etti
                            let chkcompare = cal.find("[data-id='chkcompare']").get(0);

                            $(chkcompare).bind('change', changeCompare).data('datepicker', options);

                            let selectcompare = cal.find("[data-id='selectcompare']").get(0);
                            $(selectcompare).bind('change', changeCompareOption).data('datepicker', options);

                            var group1 = [cal.find("[data-id='datedistance']").get(0), cal.find("[data-id='date1s']").get(0), cal.find("[data-id='date1e']").get(0)];
                            $.each(group1, function (x, y) {
                                $(y).on("focus", function () {
                                    options.indicator = 0;
                                    cal.find(".focus").removeClass("focus");
                                    $(this).addClass("focus");
                                }).on("click", function () {
                                    if ($(this).attr("data-id") == "date1s" || $(this).attr("data-id") == "date1e") {
                                        $(group1[0]).val(0).trigger('change');
                                    }
                                });
                            });
                            var group2 = [cal.find("[data-id='date2s']").get(0), cal.find("[data-id='date2e']").get(0)];
                            $.each(group2, function (x, y) {
                                $(y).on("focus", function () {
                                    options.indicator = 1;
                                    cal.find(".focus").removeClass("focus");
                                    $(this).addClass("focus");
                                });
                            });

                            if (options.compareWith) {
                                console.log("here's");
                                $(chkcompare).prop('checked', true);
                                $(selectcompare).val(0).removeAttr("disabled");
                                $(group2[0]).val(options.date2[0]).removeClass("disabled");;
                                $(group2[1]).val(options.date2[1]).removeClass("disabled");;
                                let secinpg2 = cal.find("[data-id='secondinputgroup']").get(0);
                                $(secinpg2).show();
                            }

                            var btnapply = cal.find("[data-id='btnapply']").get(0);
                            var btncancel = cal.find("[data-id='btncancel']").get(0);
                            var self = $(this);
                            $(btnapply).on("click", function () {
                                //let pd = prepareDate(options);
                                prepareDisplayText(options);

                                options.onChange.apply(self, prepareDate(options), options);
                                self.DatePickerHide();

                            });
                            $(btncancel).on("click", function () {
                                self.DatePickerHide();
                            });

                        }
                        fill(cal.get(0));

                        if (options.inline) {
                            cal.appendTo(this).show().css('position', 'relative');

                            layout(cal.get(0));
                        } else {
                            cal.appendTo(document.body);
                            $(this).bind(options.showOn, show);
                            prepareDisplayText(options);
                            $(ew).on("click", function () {
                                $(options.el).trigger("focus");

                            });
                        }
                    }
                });
            },

            /* 
             * Shows the DatePicker, applicable only when the picker is not inline
             * 
             * @return the DatePicker HTML element
             * @see DatePickerShow()
             */
            showPicker: function () {
                return this.each(function () {
                    if ($(this).data('datepickerId')) {
                        var cal = $('#' + $(this).data('datepickerId'));
                        var options = cal.data('datepicker');
                        if (!options.inline) {
                            show.apply(this);
                        }
                    }
                });
            },

            /* 
             * Hides the DatePicker, applicable only when the picker is not inline
             * 
             * @return the DatePicker HTML element
             * @see DatePickerHide()
             */
            hidePicker: function () {
                return this.each(function () {
                    if ($(this).data('datepickerId')) {
                        var cal = $('#' + $(this).data('datepickerId'));
                        var options = cal.data('datepicker');
                        if (!options.inline) {
                            $('#' + $(this).data('datepickerId')).hide();
                        }
                    }
                });
            },

            /* 
             * Sets the DatePicker current date, and optionally shifts the current
             * calendar to that date.
             * 
             * @param Date|String|int|Array date The currently selected date(s).  
             *        This can be: a single date, an array 
             *        of two dates (sets a range when 'mode' is 'range'), or an array of
             *        any number of dates (selects all dates when 'mode' is 'multiple'.  
             *        The supplied dates can be any one of: Date object, milliseconds 
             *        (as from date.getTime(), date.valueOf()), or a date string 
             *        parseable by Date.parse().
             * @param boolean shiftTo if true, shifts the visible calendar to the
             *        newly set date(s)
             * 
             * @see DatePickerSetDate()
             */
            setDate: function (date, shiftTo) {

                return this.each(function () {
                    if ($(this).data('datepickerId')) {
                        var cal = $('#' + $(this).data('datepickerId'));
                        var options = cal.data('datepicker');
                        options.date = normalizeDate(options.mode, date);

                        if (shiftTo) {
                            options.current = new Date(options.mode != 'single' ? options.date[0] : options.date);
                        }
                        fill(cal.get(0));
                    }
                });
            },

            /* 
             * Returns the currently selected date(s) and the datepicker element.
             * 
             * @return array where the first element is the selected date(s)  When calendar mode  is 'single' this
             *        is a single date object, or null if no date is selected.  When calendar mode is 'range', this is an array containing 
             *        a 'from' and 'to' date objects, or the empty array if no date range is selected.  When calendar mode is 'multiple' this
             *       	is an array of Date objects, or the empty array if no date is selected.
             *        The second element is the HTMLElement that DatePicker was invoked upon
             * 
             * @see DatePickerGetDate()
             */
            getDate: function () {
                if (this.size() > 0) {
                    return prepareDate($('#' + $(this).data('datepickerId')).data('datepicker'));
                }
            },

            /* 
             * Clears the currently selected date(s)
             * 
             * @see DatePickerClear()
             */
            clear: function () {
                return this.each(function () {
                    if ($(this).data('datepickerId')) {
                        var cal = $('#' + $(this).data('datepickerId'));
                        var options = cal.data('datepicker');
                        if (options.mode == 'single') {
                            options.date = null;
                        } else {
                            options.date = [];
                        }
                        fill(cal.get(0));
                    }
                });
            },

            /*
             *triggering onChange for call from global funtion or anywhere
             * 
             */
            pushOnChange: function () {
                return this.each(function () {
                    if ($(this).data('datepickerId')) {
                        var cal = $('#' + $(this).data('datepickerId'));
                        var options = cal.data('datepicker');
                        options.onChange.apply(this, prepareDate(options));
                    }
                });
            },
            /* 
             * Only applicable when the DatePicker is inline
             * 
             * @see DatePickerLayout()
             */
            fixLayout: function () {
                return this.each(function () {
                    if ($(this).data('datepickerId')) {
                        var cal = $('#' + $(this).data('datepickerId'));
                        var options = cal.data('datepicker');
                        if (options.inline) {
                            layout(cal.get(0));
                        }
                    }
                });
            }
        };
    }();  // DatePicker

    // Extend jQuery with the following functions so that they can be called on HTML elements, ie: $('#widgetCalendar').DatePicker();
    $.fn.extend({
        DatePicker: DatePicker.init,
        DatePickerHide: DatePicker.hidePicker,
        DatePickerShow: DatePicker.showPicker,
        DatePickerSetDate: DatePicker.setDate,
        DatePickerGetDate: DatePicker.getDate,
        DatePickerClear: DatePicker.clear,
        DatePickerLayout: DatePicker.fixLayout,
        DatePickerApply: DatePicker.pushOnChange

    });
})(jQuery);

(function () {
    // within here, 'this' refers to the window object
    var cache = {};

    this.tmpl = function tmpl(str, data) {
        // Figure out if we're getting a template, or if we need to
        // load the template - and be sure to cache the result.
        var fn = !/\W/.test(str) ?
            cache[str] = cache[str] ||
            tmpl(document.getElementById(str).innerHTML) :

            // Generate a reusable function that will serve as a template
            // generator (and which will be cached).
            new Function("obj",
                "var p=[],print=function(){p.push.apply(p,arguments);};" +

                // Introduce the data as local variables using with(){}
                "with(obj){p.push('" +

                // Convert the template into pure JavaScript
                str
                    .replace(/[\r\t\n]/g, " ")
                    .split("<%").join("\t")
                    .replace(/((^|%>)[^\t]*)'/g, "$1\r")
                    .replace(/\t=(.*?)%>/g, "',$1,'")
                    .split("\t").join("');")
                    .split("%>").join("p.push('")
                    .split("\r").join("\\'")
                + "');}return p.join('');");

        // Provide some basic currying to the user
        return data ? fn(data) : fn;
    };
})();

// documentation of introjs
//https://github.com/usablica/intro.js/blob/master/example/programmatic/index.html
// function startIntro(){
//         var intro = introJs();
//           intro.setOptions({
//             nextLabel:"Next",
//             nextLabel:"Previous",
//             skipLabel:"Skip Intro",
//             doneLabel:"It's over",
//             steps: [
//               {
//                 element: '#step1',
//                 intro: "panel of the first example"
//               },
//               {
//                 element: '#step1a',
//                 intro: "clicking on,<i>Range Comparison Picker</i> 'make it open",
//                 position: 'right'
//               }
//             ]
//           });
//           intro.start();
//       }
// startIntro();
