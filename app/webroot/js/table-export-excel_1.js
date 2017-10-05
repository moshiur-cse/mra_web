/*! excelexportjs 2016-06-26 */
!function(a){var b={containerid:null,datatype:"table",dataset:null,columns:null,returnUri:!1,fileName:'MF-DBMS Report',worksheetName:"MF-DBMS Data",encoding:"utf-8"},c=b;a.fn.exportToexcel=function(d){function e(){var a=c.datatype.toLowerCase();switch(f(a),a){case"table":i(g());break;case"json":i(h());break;case"xml":i(h());break;case"jqgrid":i(h())}return !1;}function f(b){switch(b){case"table":break;case"json":m=c.dataset;break;case"xml":a(c.dataset).find("row").each(function(b,c){var d={};null!=this.attributes&&this.attributes.length>0&&(a(this.attributes).each(function(){d[this.name]=this.value}),m.push(d))});break;case"jqgrid":a(c.dataset).find("rows > row").each(function(b,c){var d={};null!=this.children&&this.children.length>0&&(a(this.children).each(function(){d[this.tagName]=a(this).text()}),m.push(d))})}}function g(){var b=a("<div>").append(a("#"+c.containerid).clone()).html();return b}function h(){var b="<table>";return b+="<thead><tr>",a(c.columns).each(function(a,c){1!=this.ishidden&&(b+="<th",null!=this.width&&(b+=" style='width: "+this.width+"'"),b+=">",b+=this.headertext,b+="</th>")}),b+="</tr></thead>",b+="<tbody>",a(m).each(function(d,e){b+="<tr>",a(c.columns).each(function(a,c){e.hasOwnProperty(this.datafield)&&1!=this.ishidden&&(b+="<td",null!=this.width&&(b+=" style='width: "+this.width+"'"),b+=">",b+=e[this.datafield],b+="</td>")}),b+="</tr>"}),b+="</tbody>",b+="</table>"}function i(a){var d="<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>";d+="<head>",d+='<meta http-equiv="Content-type" content="text/html;charset='+b.encoding+'" />',d+="<!--[if gte mso 9]>",d+="<xml>",d+="<x:ExcelWorkbook>",d+="<x:ExcelWorksheets>",d+="<x:ExcelWorksheet>",d+="<x:Name>",d+="{worksheet}",d+="</x:Name>",d+="<x:WorksheetOptions>",d+="<x:DisplayGridlines/>",d+="</x:WorksheetOptions>",d+="</x:ExcelWorksheet>",d+="</x:ExcelWorksheets>",d+="</x:ExcelWorkbook>",d+="</xml>",d+="<![endif]-->",d+="</head>",d+="<body>",d+=a.replace(/"/g,"'"),d+="</body>",d+="</html>";var e="data:application/vnd.ms-excel;base64,",f={worksheet:c.worksheetName,table:a};var ul=e+j(k(d,f));var exf=(c.fileName==null)?'MF-DBMS Report':c.fileName;var dl=document.createElement("a");dl.href=ul;dl.download=exf+".xls";document.body.appendChild(dl);dl.click();document.body.removeChild(dl);return !1;}function j(a){return window.btoa(unescape(encodeURIComponent(a)))}function k(a,b){return a.replace(/{(\w+)}/g,function(a,c){return b[c]})}c=a.extend({},b,d);var l,m=[];return e()}}(jQuery);