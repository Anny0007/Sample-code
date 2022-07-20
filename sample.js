jQuery(function ($) {

	window.AVCLWPC = {};

	AVCLWPC.init = function () {

		AVCLWPC.cacheSelectors();
		AVCLWPC.onloadEventHandler();
		AVCLWPC.eventHandler();

	}

	AVCLWPC.cacheSelectors = function () {

		AVCLWPC.document = $(document);
		AVCLWPC.window = $(window);
		AVCLWPC.book_now_btn = AVCLWPC.document.find('.avclwpc_book_now_btn');
		AVCLWPC.avclwpc_index = AVCLWPC.document.find('html body').find('.avclwpc_index');
		AVCLWPC.modal = $(document).find('html body').find('.avclwpc_modal');
		AVCLWPC.seat_qty_li = AVCLWPC.modal.find('.avclwpc_seat_quantity_li');
		AVCLWPC.date_carousel_ul = $(document).find('html body').find('.avclwpc_date_carousel_ul');
		AVCLWPC.date_carousel_li = AVCLWPC.date_carousel_ul.find('.avclwpc_date_carousel_li');
		AVCLWPC.date_carousel_text_container = AVCLWPC.date_carousel_li.find('.avclwpc_date_carousel_day_month_container');
		AVCLWPC.seat_layout_modal = AVCLWPC.document.find('html body').find('.avclwpc_seat_layout_Modal');
		AVCLWPC.seat_layout_modal_content = AVCLWPC.document.find('html body').find('.avclwpc_seat_layout_Modal_content');
		AVCLWPC.footer = AVCLWPC.seat_layout_modal_content.find('.avclwpc_seat_layout_Modal_footer');
		AVCLWPC.pay_btn_in_theaterPage = AVCLWPC.seat_layout_modal.find('.avclwpc_go_to_cart');
		AVCLWPC.seat = AVCLWPC.seat_layout_modal_content.find('.avclwpc_seat');
		AVCLWPC.layout_close_btn = AVCLWPC.seat_layout_modal.find('.avclwpc_seatLayout_close');
		AVCLWPC.count = 0;
		AVCLWPC.calculated_price = 0;
		AVCLWPC.ids_array = [];
	}

	AVCLWPC.onloadEventHandler = function () {

		injectIndexInBookBtn();
		datePickerSetup();


	}

	AVCLWPC.eventHandler = function () {

		AVCLWPC.document.on('click', '.avclwpc_book_now_btn', showPopUp);
		AVCLWPC.document.on('click', '.avclwpc_close', hidePopUp);
		AVCLWPC.document.on('click', '.avclwpc_seat_quantity_li', activeListNo);
		AVCLWPC.document.on('click', '.avclwpc_get_tickets_qty_btn', showTheater);
		AVCLWPC.document.on('click', '.avclwpc_event_timing', selectShowTime);
		AVCLWPC.document.on('click', '.avclwpc_seat', clickOnSeat);
		AVCLWPC.document.on('click', '.avclwpc_go_to_cart', addToCart);
		AVCLWPC.document.on('click', '.avclwpc_seatLayout_close', closeSeatLayout);
		AVCLWPC.document.on('click', '.avclwpc_show_qty', openModal);
	}

	var closeSeatLayout = function () {

		AVCLWPC.modal.hide();
		AVCLWPC.seat_layout_modal.hide();

	}
	var openModal = function () {

		AVCLWPC.seat_layout_modal.find('.avclwpc_seat').each(function () {

			if ($(this).hasClass('avclwpc_seat_selected')) {
				$(this).removeClass('avclwpc_seat_selected');
			}
		});
		AVCLWPC.ids_array = [];
		AVCLWPC.modal.show();
		AVCLWPC.seat_layout_modal.hide();
	}

	var addToCart = function () {


		var selected_seats_count = $('.avclwpc_seat_selected').length;
		var selected_seat_ids = [];


		var selected_li_index = '';

		var array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

		AVCLWPC.seat_qty_li.each(function () {

			if ($(this).hasClass('active')) {
				selected_li_index = parseInt($(this).index());
			}

		});
		var selected_seat_qty = array[selected_li_index];

		if (selected_seats_count == selected_seat_qty) {

			$('.avclwpc_seat_selected').each(function () {
				selected_seat_ids.push($(this).attr('id'));
			});


		}

		var params = {
			'action': 'avclwpc_add_to_cart',
			'done': 1,
			'pid': avclwpc_front_ajax_obj.current_product_id,
			'time': parseInt($('.avclwpc_selected_show').attr('id')),
			'date': AVCLWPC.avclwpc_index.attr('data-index'),
			'seats': selected_seat_ids,
			'avclwpc_front_security': avclwpc_front_ajax_obj.security,

		}
		AVCLWPC.seat_layout_modal.block({
			message: '',

		});
		$.post(avclwpc_front_ajax_obj.avclwpc_ajax_url, params, function (res) {

			if (!res == '') {
				var obj = JSON.parse(res);
				if (!obj == '') {
					if (obj.success) {
						window.location.href = avclwpc_front_ajax_obj.woo_cart_url;
					} else if (obj.error) {
						alert(obj.error);


					}
				}
				AVCLWPC.seat_layout_modal.unblock();
			}

		});
	}
	var datePickerSetup = function (e) {


		$('#avclwpc_datepicker').datepicker({
			showButtonPanel: true,
			minDate: 0,
			// maxDate:'+5D',
			dateFormat: 'yy-mm-dd',
			onSelect: function (selectedDate) {

				AVCLWPC.avclwpc_index.attr('data-index', selectedDate);

			}
		});
		$('#avclwpc_datepicker').datepicker('option', 'maxDate', new Date(avclwpc_front_ajax_obj.max_date));
	}
	var selectShowTime = function (e) {
		AVCLWPC.avclwpc_group_price_array = [];
		AVCLWPC.calculated_price = 0;
		AVCLWPC.pay_btn_in_theaterPage.hide();
		var table_container = AVCLWPC.document.find('html body').find('.avclwpc_all_seats_container');
		var seats_main_table = table_container.find('.avclwpc_display_seats_main_table');
		AVCLWPC.ids_array = [];
		AVCLWPC.footer.find('.avclwpc_seat_status_boxes').show();
		if ($(this).hasClass('avclwpc_selected_show')) {
			return false;
		} else {
			AVCLWPC.seat_layout_modal.block({
				message: '',

			});
			$('.avclwpc_event_timing').each(function () {
				if ($(this).hasClass('avclwpc_selected_show')) {
					$(this).removeClass('avclwpc_selected_show')
				}
			});

			$(this).addClass('avclwpc_selected_show');

			var params = {
				'action': 'avclwpc_change_show',
				'sid': $(this).attr('id'),
				'pid': avclwpc_front_ajax_obj.current_product_id,
				'date': AVCLWPC.avclwpc_index.attr('data-index'),
				'avclwpc_front_security': avclwpc_front_ajax_obj.security,

			}
			$.post(avclwpc_front_ajax_obj.avclwpc_ajax_url, params, function (res) {
				if (!res == '') {
					var obj = JSON.parse(res);
					if (!obj == '') {
						if (obj.error) {
							return false;
						} else if (obj.success) {
							if (obj.price) {
								AVCLWPC.avclwpc_group_price_array = obj.price;
							}
							var html = $.parseHTML(obj.success);
							html = $("<div/>").html(html).text();
							seats_main_table.remove();
							table_container.append(html);
							// console.log(AVCLWPC.avclwpc_seats_main_table);
						}
					}
				}
				AVCLWPC.seat_layout_modal.unblock();
			});

		}

	}
	var clickOnSeat = function (e) {

		if ($(this).hasClass('avclwpc_booked')) {
			return false;
		}
		if ($(this).hasClass('avclwpc_blank')) {
			return false;
		}
		if ($(this).hasClass('avclwpc_seat_selected')) {
			return false;
		}

		var price = 0;
		var all_selected_seat = [];
		var selected_li_index = '';

		var array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

		AVCLWPC.seat_qty_li.each(function () {

			if ($(this).hasClass('active')) {
				selected_li_index = parseInt($(this).index());
			}

		});
		all_selected_seat = $(".avclwpc_seat_selected").map(function () {
			return $(this).length;
		}).get();

		var id = $(this).attr('id').split('|');

		AVCLWPC.footer.find('.avclwpc_seat_status_boxes').show();

		if (id != '') {

			if (isNumeric(id[0])) {

				AVCLWPC.pay_btn_in_theaterPage.hide();
				AVCLWPC.pay_btn_in_theaterPage.text('');
				id = parseInt(id[0]);
				AVCLWPC.ids_array.push(id);

			} else {

				id = 0;
			}

		}


		if (parseInt(all_selected_seat.length) < array[selected_li_index]) {


			$(this).addClass('avclwpc_seat_selected');


		} else {
			AVCLWPC.calculated_price = 0;

			$('.avclwpc_seat').each(function () {

				if ($(this).hasClass('avclwpc_seat_selected')) {

					$(this).removeClass('avclwpc_seat_selected');

				}
			});

			$(this).addClass('avclwpc_seat_selected');
			all_selected_seat = [];

		}

		if (id != 0 || typeof id != 'undefined') {


			if (!AVCLWPC.avclwpc_group_price_array || typeof AVCLWPC.avclwpc_group_price_array[id] == 'undefined') {
				return false;
			}
			price = parseFloat(AVCLWPC.avclwpc_group_price_array[id]);
			AVCLWPC.calculated_price = AVCLWPC.calculated_price + price;


			if (AVCLWPC.ids_array.length == array[selected_li_index]) {
				AVCLWPC.ids_array = [];
				AVCLWPC.pay_btn_in_theaterPage.text('Pay' + ' ' + avclwpc_front_ajax_obj.currency_symbol + AVCLWPC.calculated_price);
				AVCLWPC.footer.find('.avclwpc_seat_status_boxes').hide();
				AVCLWPC.pay_btn_in_theaterPage.show();

			}

		}

	}

	var isNumeric = function (n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}

	var injectIndexInBookBtn = function (e) {

		AVCLWPC.date_carousel_ul.find('.avclwpc_date_carousel_day_month_container').each(function () {


			if ($(this).hasClass('avclwpc_selected_date')) {

				AVCLWPC.avclwpc_index.attr('data-session-id', $(this).parent().attr('data-session-id'));
				AVCLWPC.avclwpc_index.attr('data-index', $(this).parent().attr('data-index'));
			}
		});

	}
	var slideDateListToNext = function (e) {
		e.preventDefault();
		var $this = $(this);

		var div = $(document).find('html body').find('.avclwpc_date_list_div');

		var px = -70;
		AVCLWPC.date_carousel_li.each(function () {

			if ($(this).hasClass('avclwpc_li_current') && $(this).hasClass('avclwpc_li_active')) {

				var next_li = $(this).closest('.avclwpc_date_carousel_li').next();
				if (next_li.hasClass('avclwpc_date_carousel_li')) {
					next_li.addClass('avclwpc_li_current');
					next_li.addClass('avclwpc_li_active');
					$(this).removeClass('avclwpc_li_current');
					$(this).removeClass('avclwpc_li_active');
					$(this).addClass('avclwpc_hidden');

					var len = $('.avclwpc_hidden').length;
					px = px * len;
					div.css('transform', 'translate3d(' + px + 'px, 0px, 0px)');
					$(this).css("visibility", "hidden");

					return false;
				}
			} else {


			}

		});

	}
	var slideDateListToPre = function (e) {
		e.preventDefault();
		var $this = $(this);
		var div = $(document).find('html body').find('.avclwpc_date_list_div');
		var px = 70;
		var len = $('.avclwpc_hidden').length;
		var ar = [];
		var r = div.css('transform');
		r = r.replace('matrix(', '');
		r = r.split(',');


		AVCLWPC.date_carousel_li.each(function () {

			if ($(this).hasClass('avclwpc_li_active')) {
				if ($(this).prev().length > 0) {

					$(this).removeClass('avclwpc_li_active');
					$(this).removeClass('avclwpc_li_current');

				}

				$(this).prev().addClass('avclwpc_li_active');
				$(this).prev().addClass('avclwpc_li_current');
			} else {
				var len = $('.avclwpc_hidden').length;

				if (len) {
					len = len - 1;
				}


				if ($(this).hasClass('avclwpc_hidden')) {

					px = parseInt(Math.abs(r[4]) - 70);

					px = -Math.abs(px);


					$(this).removeClass('avclwpc_hidden');
					div.css('transform', 'translate3d(' + px + ', 0px, 0px)');
					$(this).css("visibility", "unset");


				}
			}

		});




	}
	var afterDateSelected = function (e) {
		e.preventDefault();
		var $this = $(this);
		if ($this.hasClass('avclwpc_selected_date')) {


		} else {
			AVCLWPC.date_carousel_ul.find('.avclwpc_date_carousel_day_month_container').each(function () {

				$(this).removeClass('avclwpc_selected_date');
			});

			$this.addClass('avclwpc_selected_date');
			AVCLWPC.avclwpc_index.attr('data-session-id', $this.parent().attr('data-session-id'));
			AVCLWPC.avclwpc_index.attr('data-index', $(this).parent().attr('data-index'));
		}
	}
	var showPopUp = function (e) {

		e.preventDefault();
		if (AVCLWPC.avclwpc_index.attr('data-index') == '' || typeof AVCLWPC.avclwpc_index.attr('data-index') == 'undefined') {
			$('#avclwpc_datepicker').css('border-bottom', '1px solid #CC0000');
			return false;
		}

		var params = {
			'action': 'avclwpc_search_theater_by_date',
			'avclwpc_front_security': avclwpc_front_ajax_obj.security,
			'dindex': AVCLWPC.avclwpc_index.attr('data-index'),
			'tid': AVCLWPC.avclwpc_index.attr('data-tid'),
			'pid': avclwpc_front_ajax_obj.current_product_id
		};

		AVCLWPC.window.block({
			message: '',

		});
		$.post(avclwpc_front_ajax_obj.avclwpc_ajax_url, params, function (res) {
			if (res) {
				var obj = JSON.parse(res);
				if (!obj == '') {
					if (obj.error) {
						alert(obj.error);
						AVCLWPC.window.unblock();
						return false;
					} else if (obj.success) {
						AVCLWPC.modal.show();
						if (obj.price) {
							AVCLWPC.avclwpc_group_price_array = obj.price;
						}
						if (obj.time) {
							AVCLWPC.avclwpc_time_array = obj.time;
						}
						var html = $.parseHTML(obj.success);
						var decoded = $("<div/>").html(html).text();

						$('.avclwpc_seat_layout_Modal_header').remove();
						$('.avclwpc_display_date_time_container').remove();
						$('.avclwpc_seat_layout_Modal_body').remove();

						AVCLWPC.seat_layout_modal_content.append(decoded);

						$('.avclwpc_event_timing').first().addClass('avclwpc_selected_show');

					}
				}
			}
			AVCLWPC.window.unblock();
		});

	}
	var avclwpc_funclick = function (e) {
		e.preventDefault();

	}
	var hidePopUp = function (e) {
		e.preventDefault();
		AVCLWPC.modal.hide();
	}

	var activeListNo = function (e) {
		e.preventDefault();
		var $this = $(this);

		if ($this.hasClass('active')) {
			return false;
		} else {
			AVCLWPC.seat_qty_li.each(function () {
				$(this).removeClass('active');
			});
			$this.addClass('active');
		}
	}

	var showTheater = function (e) {
		e.preventDefault();
		var array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

		AVCLWPC.seat_layout_modal.show();

		var selected_li = '';
		AVCLWPC.seat_qty_li.each(function () {

			if ($(this).hasClass('active')) {
				selected_li = parseInt($(this).index());
			}

		});
		AVCLWPC.seat_layout_modal.find('.avclwpc_show_ticket_qty').find('span').text(array[selected_li] + ' Tickets');
	}
	AVCLWPC.init();

});