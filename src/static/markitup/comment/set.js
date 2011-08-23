/**
 * Markdown set for markItUp!
 */
mySettings = {
	previewInWindow: 'width=800, height=600, resizable=yes, scrollbars=yes',
	previewParserPath:  "/tools/markitup",
	onShiftEnter: {
		keepDefault:false,
		openWith:'\n\n'
	},
	markupSet: [
		{name:'Жирный', key:'B', openWith:'**', closeWith:'**'},
		{name:'Наклонный', key:'I', openWith:'_', closeWith:'_'},
		{separator:'---------------' },
		{name:'Список', openWith:'- ' },
		{name:'Нумерованный список', openWith:function(markItUp) {
			return markItUp.line+'. ';
		}},
		{separator:'---------------' },
		{name:'Ссылка', key:'L', openWith:'[', closeWith:']([![Url:!:http://]!] "[![Title]!]")', placeHolder:'Текст ссылки' },
		{separator:'---------------'},
		{name:'Цитата', openWith:'> '},
		{name:'Код', openWith:'\n~~~\n[php]\n', closeWith:'\n~~~\n'},
		{separator:'---------------'},
		{name:'Предпросмотр', call:'preview' },
	]
}

// mIu nameSpace to avoid conflict.
miu = {
	markdownTitle: function(markItUp, char) {
		heading = '';
		n = $.trim(markItUp.selection||markItUp.placeHolder).length;
		for(i = 0; i < n; i++) {
			heading += char;
		}
		return '\n'+heading;
	}
}