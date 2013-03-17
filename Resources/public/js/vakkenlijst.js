$(document).ready(function(){
	$('#faculties').hide();
	$('#levels').hide();
	$('#studies').hide();
	$('#programs').hide();
	$('#stages').hide();
	$('#courses').hide();

	$.getJSON('{{ path('dellaert_kul_education_api_list_faculties_by_id_title', {'_locale': app.request.locale}) }}', function(data){
		var len = data.length;
		if( len == 0 ) {
			var html = '<option value="-1">{% trans %}no.faculty{% endtrans %}</option>'
		} else {
			var html = '<option value="-1">{% trans %}choose.faculty{% endtrans %}</option>';
		}
		for( var i=0; i < len; i++ ){
			html += '<option value="' + data[i].id + '">' + data[i].title + '</option>';
		}
		$('#faculties').html(html);
	});
	$('#faculties').show();

	$('#faculties').change(function(){
		$('#courses').hide();
		var html = '';
		$('#courses').html(html);
		$('#stages').hide();
		var html = '<option value="-1">{% trans %}choose.stage{% endtrans %}</option>';
		$('#stages').html(html);
		$('#programs').hide();
		var html = '<option value="-1">{% trans %}choose.program{% endtrans %}</option>';
		$('#programs').html(html);
		$('#studies').hide();
		var html = '<option value="-1">{% trans %}choose.study{% endtrans %}</option>';
		$('#studies').html(html);

		if( $(this).val() != -1 ) {
			$.getJSON('{{ path('dellaert_kul_education_api_list_levels_by_id_title_noid', {'_locale': app.request.locale}) }}/' + $(this).val(), function(data) {
				var len = data.length;
				if( len == 0 ) {
					var html = '<option value="-1">{% trans %}no.level{% endtrans %}</option>'
				} else {
					var html = '<option value="-1">{% trans %}choose.level{% endtrans %}</option>';
				}
				for( var i=0; i < len; i++ ){
					html += '<option value="' + data[i].id + '">' + data[i].title + '</option>';
				}
				$('#levels').html(html);
			});
			$('#levels').show();
		} else {
			$('#levels').hide();
			var html = '<option value="-1">{% trans %}choose.level{% endtrans %}</option>';
			$('#levels').html(html);
		}
	});

	$('#levels').change(function(){
		$('#courses').hide();
		var html = '';
		$('#courses').html(html);
		$('#stages').hide();
		var html = '<option value="-1">{% trans %}choose.stage{% endtrans %}</option>';
		$('#stages').html(html);
		$('#programs').hide();
		var html = '<option value="-1">{% trans %}choose.program{% endtrans %}</option>';
		$('#programs').html(html);

		if( $(this).val() != -1 ) {
			$.getJSON('{{ path('dellaert_kul_education_api_list_studies_by_id_title_noid', {'_locale': app.request.locale}) }}/' + $('#faculties').val() + '/' + $(this).val(), function(data) {
				var len = data.length;
				if( len == 0 ) {
					var html = '<option value="-1">{% trans %}no.study{% endtrans %}</option>'
				} else {
					var html = '<option value="-1">{% trans %}choose.study{% endtrans %}</option>';
				}
				for( var i=0; i < len; i++ ){
					html += '<option value="' + data[i].id + '">' + data[i].title + '</option>';
				}
				$('#studies').html(html);
			});
			$('#studies').show();
		} else {
			$('#studies').hide();
			var html = '<option value="-1">{% trans %}choose.study{% endtrans %}</option>';
			$('#studies').html(html);
		}
	});

	$('#studies').change(function(){
		$('#courses').hide();
		var html = '';
		$('#courses').html(html);
		$('#stages').hide();
		var html = '<option value="-1">{% trans %}choose.stage{% endtrans %}</option>';
		$('#stages').html(html);

		if( $(this).val() != -1 ) {
			$.getJSON('{{ path('dellaert_kul_education_api_list_programs_by_id_title_noid', {'_locale': app.request.locale}) }}/' + $(this).val(), function(data) {
				var len = data.length;
				if( len == 0 ) {
					var html = '<option value="-1">{% trans %}no.program{% endtrans %}</option>'
				} else {
					var html = '<option value="-1">{% trans %}choose.program{% endtrans %}</option>';
				}
				for( var i=0; i < len; i++ ){
					html += '<option value="' + data[i].id + '">' + data[i].title + ' (' + data[i].studypoints + ' {% trans %}studypoints{% endtrans %})</option>';
				}
				$('#programs').html(html);
			});
			$('#programs').show();
		} else {
			$('#programs').hide();
			var html = '<option value="-1">{% trans %}choose.program{% endtrans %}</option>';
			$('#programs').html(html);
		}
	});

	$('#programs').change(function(){
		$('#courses').hide();
		var html = '';
		$('#courses').html(html);

		if( $(this).val() != -1 ) {
			$.getJSON('{{ path('dellaert_kul_education_api_list_stages_by_id_title_noid', {'_locale': app.request.locale}) }}/' + $(this).val(), function(data) {
				var len = data.length;
				if( len == 0 ) {
					var html = '<option value="-1">{% trans %}no.stage{% endtrans %}</option>'
				} else {
					var html = '<option value="-1">{% trans %}choose.stage{% endtrans %}</option>';
				}
				for( var i=0; i < len; i++ ){
					html += '<option value="' + data[i].id + '">{% trans %}stage{% endtrans %} ' + data[i].id + '</option>';
				}
				$('#stages').html(html);
			});
			$('#stages').show();
		} else {
			$('#stages').hide();
			var html = '<option value="-1">{% trans %}choose.stage{% endtrans %}</option>';
			$('#stages').html(html);
		}
	});

	$('#stages').change(function(){				
		if( $(this).val() != -1 ) {
			$.getJSON('{{ path('dellaert_kul_education_api_list_courses_noids', {'_locale': app.request.locale}) }}/' + $('#programs').val() + '/' + $(this).val(), function(data) {
				var html = '';

				if( typeof data.mandatory != 'undefined' ) {
					var len = data.mandatory.length;
				} else {
					var len = 0;
				}

				if( len > 0 ) {
					html += '<b>{% trans %}course.mandatory{% endtrans %}</b><br />'
						+'<table><tr><td><b>{% trans %}course.id{% endtrans %}</b></td>'
						+'<td><b>{% trans %}course.title{% endtrans %}</b></td>'
						+'<td><b>{% trans %}course.period{% endtrans %}</b></td>'
						+'<td><b>{% trans %}course.studypoints{% endtrans %}</b></td>'
						+'<td><b>{% trans %}course.teachers{% endtrans %}</b></td></tr>';

					for( var i=0; i < len; i++ ) {
						html += '<tr><td>'+data.mandatory[i].course_id+'</td>'
							+'<td>'+data.mandatory[i].title+'</td>'
							+'<td>'+data.mandatory[i].period+'</td>'
							+'<td>'+data.mandatory[i].studypoints+'</td>'
							+'<td>';
						lenteachers = data.mandatory[i].teachers.length;
						for( var j=0; j<lenteachers; j++ ) {
							html += data.mandatory[i].teachers[j].lastname+', '+data.mandatory[i].teachers[j].firstname;
							if( j < lenteachers-1 ) {
								html += '; ';
							}
						}
						html += '</td></tr>';
					}

					html += '</table><br />';
				}

				if( typeof data.optional != 'undefined' ) {
					var len = data.optional.length;
				} else {
					var len = 0;
				}

				if( len > 0 ) {
					html += '<b>{% trans %}course.optional{% endtrans %}</b><br />'
						+'<table><tr><td><b>{% trans %}course.id{% endtrans %}</b></td>'
						+'<td><b>{% trans %}course.title{% endtrans %}</b></td>'
						+'<td><b>{% trans %}course.period{% endtrans %}</b></td>'
						+'<td><b>{% trans %}course.studypoints{% endtrans %}</b></td>'
						+'<td><b>{% trans %}course.teachers{% endtrans %}</b></td></tr>';

					for( var i=0; i < len; i++ ) {
						html += '<tr><td>'+data.optional[i].course_id+'</td>'
							+'<td>'+data.optional[i].title+'</td>'
							+'<td>'+data.optional[i].period+'</td>'
							+'<td>'+data.optional[i].studypoints+'</td>'
							+'<td>';
						lenteachers = data.optional[i].teachers.length;
						for( var j=0; j<lenteachers; j++ ) {
							html += data.optional[i].teachers[j].lastname+', '+data.optional[i].teachers[j].firstname;
							if( j < lenteachers-1 ) {
								html += '; ';
							}
						}
						html += '</td></tr>';
					}
				}

				if( html == '' ) {
					html = '{% trans %}no.course{% endtrans %}';
				}

				$('#courses').html(html);


			});
			$('#courses').show();
		} else {
			$('#courses').hide();
			var html = '';
			$('#courses').html(html);
		}
	});
});