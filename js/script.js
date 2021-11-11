'use strict';
//Проверка загрузки документа
document.addEventListener('DOMContentLoaded', function() {
	const form = document.getElementById('form');
	form.addEventListener('submit', formSend);
	//Запрет отправки формы по кнопке
	async function formSend(e) {
		e.preventDefault();
		//Валидация полей формы
		let error = formValidate(form);
		let formData = new FormData(form);
		//Отправка данных формы асинхронной функцией методом POST
		if (error === 0) {
			form.classList.add('_sending');
			let response = await fetch('sendmail.php', {
				method: 'POST',
				body: formData
			});
			if (response.ok) {
				let result = await response.json();
				alert(result.message);
				form.reset();
				form.classList.remove('_sending');
			} else {
				alert('Ошибка');
				form.classList.remove('_sending');
			}
		} else {
			alert('Не все поля заполнены');
		}
	}
	//Проверка обязательных полей
	function formValidate(form) {
		let error = 0;
		let formRequired = document.querySelectorAll('._required');

		for (let index = 0; index < formRequired.length; index++) {
			const input = formRequired[index];
			formRemoveError(input);
			//Проверка поля email на символы
			if (input.classList.contains('_email')) {
				if (validateEmail(input)) {
					formAddError(input);
					error++;
				}
				//Проверка строки на заполнение
			} else {
				if (input.value === '') {
					formAddError(input);
					error++;
				}
			}
		}
		return error;

		//Функция добавляет объектам класс ошибки
		function formAddError(input) {
			input.parentElement.classList.add('_error');
			input.classList.add('_error');
		}
		//Функция убирает у объектов класс ошибки
		function formRemoveError(input) {
			input.parentElement.classList.remove('_error');
			input.classList.remove('_error');
		}
	}

	//Проверка email
	function validateEmail(input) {
		return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
	}
});
