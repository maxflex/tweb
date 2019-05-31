(function(){var indexOf=[].indexOf||function(item){for(var i=0,l=this.length;i<l;i++)if(i in this&&this[i]===item)return i;return-1};angular.module("App",["ngResource","ngAnimate","angular-ladda","angularFileUpload","angular-toArrayFilter","thatisuday.ng-image-gallery","thatisuday.ng-image-gallery-2","ngSanitize"]).config(["ngImageGalleryOptsProvider",function(ngImageGalleryOptsProvider){return ngImageGalleryOptsProvider.setOpts({bubbles:!0,bubbleSize:165})}]).config(["ngImageGalleryOpts2Provider",function(ngImageGalleryOpts2Provider){return ngImageGalleryOpts2Provider.setOpts({bubbles:!0,bubbleSize:165})}]).config(["$compileProvider",function($compileProvider){return $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|chrome-extension|sip):/)}]).config(function(laddaProvider){return laddaProvider.setOption({spinnerColor:"#83b060"})}).filter("youtubeEmbedUrl",function($sce){return function(videoId){return $sce.trustAsResourceUrl("https://www.youtube.com/embed/"+videoId+"?enablejsapi=1&showinfo=0&rel=0")}}).filter("cut",function(){return function(value,wordwise,max,tail){var lastspace;return null==tail&&(tail=""),value?(max=parseInt(max,10))?value.length<=max?value:(value=value.substr(0,max),wordwise&&(lastspace=value.lastIndexOf(" "),lastspace!==-1&&("."!==value.charAt(lastspace-1)&&","!==value.charAt(lastspace-1)||(lastspace-=1),value=value.substr(0,lastspace))),value+tail):value:""}}).filter("hideZero",function(){return function(item){return item>0?item:null}}).run(function($rootScope,$q,StreamService){return $rootScope.streamLink=streamLink,$rootScope.StreamService=StreamService,$rootScope.eventUrl=eventUrl,$rootScope.eventAction=eventAction,$rootScope.dataLoaded=$q.defer(),$rootScope.frontendStop=function(rebind_masks){if(null==rebind_masks&&(rebind_masks=!0),$rootScope.frontend_loading=!1,$rootScope.dataLoaded.resolve(!0),rebind_masks)return rebindMasks()},$rootScope.range=function(min,max,step){var i,input;for(step=step||1,input=[],i=min;i<=max;)input.push(i),i+=step;return input},$rootScope.withTailingDot=function(text){var char;return text=text.trim(),char=text[text.length-1],["!","."].indexOf(char)===-1&&(text+="."),text},$rootScope.toggleEnum=function(ngModel,status,ngEnum,skip_values,allowed_user_ids,recursion){var ref,ref1,ref2,status_id,statuses;if(null==skip_values&&(skip_values=[]),null==allowed_user_ids&&(allowed_user_ids=[]),null==recursion&&(recursion=!1),!(!recursion&&(ref=parseInt(ngModel[status]),indexOf.call(skip_values,ref)>=0)&&(ref1=$rootScope.$$childHead.user.id,indexOf.call(allowed_user_ids,ref1)<0)))return statuses=Object.keys(ngEnum),status_id=statuses.indexOf(ngModel[status].toString()),status_id++,status_id>statuses.length-1&&(status_id=0),ngModel[status]=statuses[status_id],indexOf.call(skip_values,status_id)>=0&&(ref2=$rootScope.$$childHead.user.id,indexOf.call(allowed_user_ids,ref2)<0)?$rootScope.toggleEnum(ngModel,status,ngEnum,skip_values,allowed_user_ids,!0):void 0},$rootScope.toggleEnumServer=function(ngModel,status,ngEnum,Resource){var status_id,statuses,update_data;return statuses=Object.keys(ngEnum),status_id=statuses.indexOf(ngModel[status].toString()),status_id++,status_id>statuses.length-1&&(status_id=0),update_data={id:ngModel.id},update_data[status]=status_id,Resource.update(update_data,function(){return ngModel[status]=statuses[status_id]})},$rootScope.formatDateTime=function(date){return moment(date).format("DD.MM.YY в HH:mm")},$rootScope.formatDate=function(date,full_year){return null==full_year&&(full_year=!1),date?moment(date).format("DD.MM.YY"+(full_year?"YY":"")):""},$rootScope.formatDateFull=function(date){return moment(date).format("D MMMM YYYY")},$rootScope.dialog=function(id){$("#"+id).modal("show")},$rootScope.closeDialog=function(id){$("#"+id).modal("hide")},$rootScope.onEnter=function(event,fun,prevent_default){if(null==prevent_default&&(prevent_default=!0),prevent_default&&event.preventDefault(),13===event.keyCode)return fun()},$rootScope.ajaxStart=function(){return ajaxStart(),$rootScope.saving=!0},$rootScope.ajaxEnd=function(){return ajaxEnd(),$rootScope.saving=!1},$rootScope.findById=function(object,id){return _.findWhere(object,{id:parseInt(id)})},$rootScope.total=function(array,prop,prop2){var sum;return null==prop2&&(prop2=!1),sum=0,$.each(array,function(index,value){var v;return v=value[prop],prop2&&(v=v[prop2]),sum+=v}),sum},$rootScope.yearsPassed=function(year){return moment().format("YYYY")-year},$rootScope.deny=function(ngModel,prop){return ngModel[prop]=+!ngModel[prop]},$rootScope.closestMetro=function(markers){var closest_metro;return closest_metro=markers[0].metros[0],markers.forEach(function(marker){return marker.metros.forEach(function(metro){if(metro.minutes<closest_metro.minutes)return closest_metro=metro})}),closest_metro.station.title},$rootScope.closestMetros=function(markers){var closest_metros;return closest_metros=[],markers.forEach(function(marker,index){return closest_metros[index]=marker.metros[0],marker.metros.forEach(function(metro){if(metro.minutes<closest_metros[index].minutes)return closest_metros[index]=metro})}),closest_metros},$rootScope.fullName=function(tutor){return tutor.last_name+" "+tutor.first_name+" "+tutor.middle_name},$rootScope.objectLength=function(obj){return Object.keys(obj).length},$rootScope.shortenGrades=function(tutor){var a,combo_end,combo_start,grade_string,grades,i,j,last_grade,limit,pairs;if(tutor.grades.length<=3)return grades=_.clone(tutor.grades),grades.length>1&&(last_grade=grades.pop()),grade_string=grades.join(", "),last_grade&&(grade_string+=" и "+last_grade),grade_string+(last_grade?" классы":" класс");if(a=_.clone(tutor.grades),!(a.length<1)){for(limit=a.length-1,combo_end=-1,pairs=[],i=0;i<=limit;)if(combo_start=parseInt(a[i]),combo_start>11)i++,combo_end=-1,pairs.push(combo_start);else if(combo_start<=combo_end)i++;else{for(j=i;j<=limit&&(combo_end=parseInt(a[j]),!(combo_end>=11))&&!(parseInt(a[j+1])-combo_end>1);)j++;combo_start!==combo_end?pairs.push(combo_start+"–"+combo_end+" классы"):pairs.push(combo_start+" класс"),i++}return pairs.join(", ")}},$rootScope.countObj=function(obj){return Object.keys(obj).length},$rootScope.formatBytes=function(bytes){return bytes<1024?bytes+" Bytes":bytes<1048576?(bytes/1024).toFixed(1)+" KB":bytes<1073741824?(bytes/1048576).toFixed(1)+" MB":(bytes/1073741824).toFixed(1)+" GB"}})}).call(this),function(){window.PriceExpander=function(){function PriceExpander(n){this.n=n}return PriceExpander.prototype.base_class=".price-list:visible",PriceExpander.prototype.li_class="li",PriceExpander.prototype._expand=function(level){var expanded,i,j,ref,selector;for(null==level&&(level=1),selector=[this.base_class],i=j=0,ref=level-1;0<=ref?j<=ref:j>=ref;i=0<=ref?++j:--j)selector.push(this.li_class);if(selector=selector.join(" "),expanded=!1,$(selector).each(function(_this){return function(i,e){expanded||(e=$(e).children().children(".price-section"),e.length>0&&(e.parent().children("ul").is(":visible")||(e.click(),_this.isExpanded()&&(expanded=!0))))}}(this)),!expanded&&level<5)return this._expand(level+1)},PriceExpander.prototype.getLength=function(){return $([this.base_class,this.li_class].join(" ")).length},PriceExpander.prototype.isExpanded=function(){return this.getLength()>this.n},PriceExpander.expand=function(n){var expander;return expander=new PriceExpander(n),expander._expand()},PriceExpander}()}.call(this),function(){angular.module("App").controller("Gallery",function($scope,$timeout,StreamService){return bindArguments($scope,arguments),angular.element(document).ready(function(){return $scope.all_photos=[],_.each($scope.groups,function(group){return $scope.all_photos=$scope.all_photos.concat(group.photo)})}),$scope.openPhoto=function(photo_id){return StreamService.run("photogallery","open_"+photo_id),$scope.gallery.open($scope.getFlatIndex(photo_id))},$scope.getFlatIndex=function(photo_id){return _.findIndex($scope.all_photos,{id:photo_id})}})}.call(this),function(){angular.module("App").controller("main",function($scope,$timeout,$http,GalleryService){var initGmap;return bindArguments($scope,arguments),$scope.galleryLoaded=!1,$scope.GalleryService2=_.clone(GalleryService),$scope.initGallery=function(ids,tags,folders,isFirst){return null==isFirst&&(isFirst=!0),$http.post("/api/gallery/init",{ids:ids,tags:tags,folders:folders}).then(function(response){return $timeout(function(){return isFirst&&($scope.gallery=response.data),isFirst||($scope.gallery2=response.data),$scope.galleryLoaded=!0},3e3)})},$timeout(function(){return PriceExpander.expand(isMobile?15:30),initGmap()}),initGmap=function(){var markers;if($scope.map=new google.maps.Map(document.getElementById("map"),{scrollwheel:!1,disableDefaultUI:!0,clickableLabels:!1,clickableIcons:!1,zoomControl:!0,zoomControlOptions:{position:google.maps.ControlPosition.RIGHT_CENTER},scaleControl:!1}),$scope.bounds=new google.maps.LatLngBounds,markers=[newMarker(new google.maps.LatLng(55.717295,37.595088),$scope.map),newMarker(new google.maps.LatLng(55.781302,37.516045),$scope.map)],markers.forEach(function(marker){var marker_location;return marker_location=new google.maps.LatLng(marker.lat,marker.lng),$scope.bounds.extend(marker_location)}),$scope.map.fitBounds($scope.bounds),$scope.map.panToBounds($scope.bounds),isMobile)return window.onOpenModal=function(){return google.maps.event.trigger($scope.map,"resize"),$scope.map.fitBounds($scope.bounds),$scope.map.panToBounds($scope.bounds)}}})}.call(this),function(){angular.module("App").controller("master",function($scope,$timeout,$http,Master,GalleryService){return bindArguments($scope,arguments),$scope.reviews_block=!1,$scope.gallery=[],$scope.galleryLoaded=!1,$scope.initGallery=function(ids,tags,folders){if(ids)return $http.post("/api/gallery/init",{ids:ids,tags:tags,folders:folders}).then(function(response){return $scope.gallery=response.data,$scope.galleryLoaded=!0})},$scope.toggleShow=function(master,prop,iteraction_type,index){return null==index&&(index=null),master[prop]?$timeout(function(){return master[prop]=!1},$scope.mobile?400:0):master[prop]=!0},$scope.popup=function(id,master,fn,index){if(null==master&&(master=null),null==fn&&(fn=null),null==index&&(index=null),openModal(id),null!==master&&($scope.popup_master=master),null!==fn)return $timeout(function(){return $scope[fn](master,index)})}})}.call(this),function(){angular.module("App").controller("masters",function($scope){return bindArguments($scope,arguments)})}.call(this),function(){angular.module("App").controller("order",function($scope,$timeout,$http,Grades,Subjects,Request,StreamService){return bindArguments($scope,arguments),$timeout(function(){return $scope.order={photos:[]},$scope.popups={},$scope.agreement=!0,$scope.max_photos=5,$("body").on("drop dragover",function(e){return e.preventDefault(),!1}),$("#fileupload").fileupload({maxFileSize:5e6,send:function(e,data){return data.files[0].size>5242880?($scope.upload_error="максимальный объём файла – 5 Мб",$scope.$apply(),!1):($scope.upload_error=null,$scope.order.photos.push(null),$scope.$apply())},progress:function(e,data){return $scope.uploaded_percentage=Math.round(data.loaded/data.total*100),$scope.$apply()},done:function(_this){return function(i,response){return response.result.hasOwnProperty("error")?($scope.order.photos.splice(-1),$scope.upload_error=response.result.error,eventAction("stat-order-error",response.result.error)):($scope.order.photos[$scope.order.photos.length-1]=response.result,eventAction("stat-file-attach",$scope.order.photos.length)),$scope.$apply()}}(this)})}),$scope.photoUploading=function(){return null===$scope.order.photos[$scope.order.photos.length-1]},$scope.filterPopup=function(popup){return $scope.popups[popup]=!0},$scope.select=function(field,value){return $scope.order[field]=value,$scope.popups={}},$scope.photosAllowed=function(){return $scope.max_photos-$scope.order.photos.length},$scope.fileChange=function(event){},$scope.request=function(){return $scope.sending=!0,$scope.errors={},Request.save($scope.order,function(){return $scope.sending=!1,$scope.sent=!0,eventAction("stat-order"),$("body").animate({scrollTop:$(".header").offset().top})},function(response){var errors_string;return $scope.sending=!1,errors_string=[],angular.forEach(response.data,function(errors,field){var input,selector;if($scope.errors[field]=errors,errors_string.push(field+": "+errors.join(", ")),selector="[ng-model$='"+field+"']",$("html,body").animate({scrollTop:$("input"+selector+", textarea"+selector).first().offset().top},0),input=$("input"+selector+", textarea"+selector),input.focus(),isMobile)return input.notify(errors[0],notify_options)}),eventAction("stat-order-error",errors_string.join(" | "))})}})}.call(this),function(){angular.module("App").controller("other",function($scope){return bindArguments($scope,arguments)})}.call(this),function(){angular.module("App").controller("price",function($scope){return bindArguments($scope,arguments)})}.call(this),function(){angular.module("App").constant("REVIEWS_PER_PAGE",5).controller("reviews",function($scope,$timeout,$http,Subjects,StreamService){var search;return bindArguments($scope,arguments),$timeout(function(){return $scope.reviews=[],$scope.page=1,$scope.has_more_pages=!0,search()}),$scope.popup=function(index){return $scope.show_review=index},$scope.nextPage=function(){return StreamService.run("all_reviews","more"),$scope.page++,search()},search=function(){return $scope.searching=!0,$http.get("/api/reviews/bypage?page="+$scope.page).then(function(response){return $scope.searching=!1,$scope.reviews=$scope.reviews.concat(response.data.reviews),$scope.has_more_pages=response.data.has_more_pages})}})}.call(this),function(){angular.module("App").value("AvgScores",{"1-11-1":46.3,"2-11":51.2,"3-11":56.1,"4-11":52.8,"5-11":53,"6-11":65.8,"7-11":56,"8-11":53.3,"9-11":48.1,"10-11":64.2,"11-11":53}).value("Units",[{id:1,title:"изделие"},{id:2,title:"штука"},{id:3,title:"сантиметр"},{id:4,title:"пара"},{id:5,title:"метр"},{id:6,title:"дм²"},{id:7,title:"см²"},{id:8,title:"мм²"},{id:9,title:"элемент"}]).value("Grades",{9:"9 класс",10:"10 класс",11:"11 класс"}).value("Subjects",{all:{1:"математика",2:"физика",3:"химия",4:"биология",5:"информатика",6:"русский",7:"литература",8:"обществознание",9:"история",10:"английский",11:"география"},full:{1:"Математика",2:"Физика",3:"Химия",4:"Биология",5:"Информатика",6:"Русский язык",7:"Литература",8:"Обществознание",9:"История",10:"Английский язык",11:"География"},dative:{1:"математике",2:"физике",3:"химии",4:"биологии",5:"информатике",6:"русскому языку",7:"литературе",8:"обществознанию",9:"истории",10:"английскому языку",11:"географии"},"short":["М","Ф","Р","Л","А","Ис","О","Х","Б","Ин","Г"],three_letters:{1:"МАТ",2:"ФИЗ",3:"ХИМ",4:"БИО",5:"ИНФ",6:"РУС",7:"ЛИТ",8:"ОБЩ",9:"ИСТ",10:"АНГ",11:"ГЕО"},short_eng:{1:"math",2:"phys",3:"chem",4:"bio",5:"inf",6:"rus",7:"lit",8:"soc",9:"his",10:"eng",11:"geo"}})}.call(this),function(){angular.module("App").directive("academic",function(){return{restrict:"E",template:"{{ year }}–{{ +(year) + 1 }}",scope:{year:"="}}})}.call(this),function(){angular.module("App").directive("digitsOnly",function(){return{restrics:"A",require:"ngModel",link:function($scope,$element,$attr,$ctrl){var filter,ref;return filter=function(value){var new_value;if(value)return new_value=value.replace(/[^0-9]/g,""),new_value!==value&&($ctrl.$setViewValue(new_value),$ctrl.$render()),value},null!=(ref=$ctrl.$parsers)?ref.push(filter):void 0}}})}.call(this),function(){angular.module("App").directive("errors",function(){return{restrict:"E",templateUrl:"/directives/errors",scope:{model:"@"},controller:function($scope,$element,$attrs){return $scope.only_first=$attrs.hasOwnProperty("onlyFirst"),$scope.getErrors=function(){var errors;if(void 0!==$scope.$parent.errors&&(errors=$scope.$parent.errors[$scope.model]))return $scope.only_first?[errors[0]]:errors}}}})}.call(this),function(){angular.module("App").directive("galleryItemMain",function(){return{restrict:"E",scope:{item:"=",service:"="},templateUrl:"/directives/gallery-item-main"}})}.call(this),function(){angular.module("App").directive("galleryItem",function(){return{restrict:"E",scope:{item:"=",service:"=",index:"="},templateUrl:function(elem,attrs){return isMobile?"/directives/gallery-item-mobile":"/directives/gallery-item"}}})}.call(this),function(){}.call(this),function(){angular.module("App").directive("ngMark",function(){return{restrict:"A",scope:{word:"@"},controller:function($scope,$element,$attrs,$timeout){return $timeout(function(){return $($element).mark($scope.word,{separateWordSearch:!0,accuracy:{value:"exactly",limiters:["!","@","#","&","*","(",")","-","–","—","+","=","[","]","{","}","|",":",";","'",'"',"‘","’","“","”",",",".","<",">","/","?"]}})})}}})}.call(this),function(){angular.module("App").directive("ngPhone",function(){return{restrict:"A",link:function($scope,element){return $(element).inputmask("+7 (999) 999-99-99",{autoclear:!1,showMaskOnHover:!1})}}})}.call(this),function(){angular.module("App").directive("plural",function(){return{restrict:"E",scope:{count:"=",type:"@",noneText:"@"},templateUrl:"/directives/plural",controller:function($scope,$element,$attrs,$timeout){return $scope.textOnly=$attrs.hasOwnProperty("textOnly"),$scope.hideZero=$attrs.hasOwnProperty("hideZero"),$scope.when={age:["год","года","лет"],student:["ученик","ученика","учеников"],minute:["минуту","минуты","минут"],hour:["час","часа","часов"],day:["день","дня","дней"],rubbles:["рубль","рубля","рублей"],client:["клиент","клиента","клиентов"],mark:["оценки","оценок","оценок"],review:["отзыв","отзыва","отзывов"],request:["заявка","заявки","заявок"],profile:["анкета","анкеты","анкет"],address:["адрес","адреса","адресов"],person:["человек","человека","человек"],ton:["тонна","тонны","тонн"],yacht:["яхта","яхты","яхт"],photo:["фото","фотографии","фотографий"]}}}})}.call(this),function(){angular.module("App").directive("priceItem",function(){return{restrict:"E",templateUrl:function(elem,attrs){return isMobile?"/directives/price-item-mobile":"/directives/price-item"},scope:{item:"=",level:"="},controller:function($scope,$timeout,$rootScope,PriceSection,PricePosition,Units){return $scope.Units=Units,$scope.findById=$rootScope.findById,$scope.controller_scope=scope,$scope.priceRounded=function(price){return 10*Math.round(price/10)},$scope.getStyle=function(){var offset;return offset=20*$scope.level+"px",{left:offset,width:"calc(100% - "+offset+")"}},$scope.toggle=function(item,event){var event_name,target,ul;if(item.items&&item.items.length)return target=$(event.target).hasClass("price-line")?$(event.target):$(event.target).closest(".price-line"),target.toggleClass("active"),ul=target.parent().children("ul"),event_name=ul.is(":visible")?prefixEvent("price-minimize"):prefixEvent("price-expand"),eventAction(event_name,item.model.name),ul.slideToggle(250)}}}})}.call(this),function(){angular.module("App").directive("programItem",function(){return{templateUrl:"/directives/program",scope:{item:"=",level:"=?",levelstring:"="},controller:function($timeout,$element,$scope){return $scope.level||($scope.level=0),$scope.getChildLevelString=function(child_index){var str;return str=$scope.levelstring?$scope.levelstring:"",str+(child_index+1)+"."}}}})}.call(this),function(){}.call(this),function(){var apiPath,countable,updatable;angular.module("App").factory("Master",function($resource){return $resource(apiPath("masters"),{id:"@id",type:"@type"},{search:{method:"POST",url:apiPath("masters","search")},reviews:{method:"GET",isArray:!0,url:apiPath("reviews")}})}).factory("Request",function($resource){return $resource(apiPath("requests"),{id:"@id"},updatable())}).factory("Cv",function($resource){return $resource(apiPath("cv"),{id:"@id"},updatable())}).factory("PriceSection",function($resource){return $resource(apiPath("prices"),{id:"@id"},updatable())}).factory("PricePosition",function($resource){return $resource(apiPath("prices/positions"),{id:"@id"},updatable())}).factory("Stream",function($resource){return $resource(apiPath("stream"),{id:"@id"})}),apiPath=function(entity,additional){return null==additional&&(additional=""),"/api/"+entity+"/"+(additional?additional+"/":"")+":id"},updatable=function(){return{update:{method:"PUT"}}},countable=function(){return{count:{method:"GET"}}}}.call(this),function(){angular.module("App").service("GalleryService",function(){var DIRECTION,animation_in_progress,el,scroll_left;return this.displayed=3,el=null,scroll_left=null,DIRECTION={next:1,prev:0},animation_in_progress=!1,this.open=function(index){return this.ctrl.open(index)},this.init=function(gallery){return this.gallery=gallery,this.gallery.push(gallery[0]),this.gallery.unshift(gallery[gallery.length-2]),el=$(".main-gallery-block"),this.screen_width=$(".main-gallery-block .gallery-item").first().outerWidth(),this.setActive(1)},this.next=function(){if(!animation_in_progress)return this.rotateControl(DIRECTION.next),this.setActive(this.active+1)},this.prev=function(){if(!animation_in_progress)return this.rotateControl(DIRECTION.prev),this.setActive(this.active-1)},this.setActive=function(index){return this.active=index,this.scroll()},this.rotateControl=function(direction){if(1===this.active&&direction===DIRECTION.prev&&(this.active=this.gallery.length-1,this.scroll(0)),this.active===this.gallery.length-2&&direction===DIRECTION.next)return this.active=0,this.scroll(0)},this.scroll=function(animation_speed){return null==animation_speed&&(animation_speed=500),animation_in_progress=!0,el.stop().animate({scrollLeft:this.screen_width*this.active+this.screen_width-($(window).width()-this.screen_width)/2},animation_speed,function(){return animation_in_progress=!1})},this})}.call(this),function(){angular.module("App").service("PhoneService",function(){var isFull;return this.checkForm=function(element){var phone_element,phone_number;return phone_element=$(element).find(".phone-field"),isFull(phone_element.val())?(phone_number=phone_element.val().match(/\d/g).join(""),"4"===phone_number[1]||"9"===phone_number[1]||(phone_element.focus().notify("номер должен начинаться с 9 или 4",notify_options),!1)):(phone_element.focus().notify("номер телефона не заполнен полностью",notify_options),!1)},isFull=function(number){return void 0!==number&&""!==number&&!number.match(/_/)},this})}.call(this),function(){angular.module("App").service("StreamService",function($http,$timeout,Stream){return this.identifySource=function(tutor){return null==tutor&&(tutor=void 0),void 0!==tutor&&tutor.is_similar?"similar":RegExp(/^\/[\d]+$/).test(window.location.pathname)?"tutor":"/request"===window.location.pathname?"help":"/"===window.location.pathname?"main":"serp"},this.generateEventString=function(params){var parts,search;return search=$.cookie("search"),void 0!==search&&$.each(JSON.parse(search),function(key,value){return params[key]=value}),parts=[],$.each(params,function(key,value){var where;switch(key){case"sort":switch(parseInt(value)){case 2:value="maxprice";break;case 3:value="minprice";break;case 4:value="rating";break;case 5:value="bymetro";break;default:value="pop"}break;case"place":switch(parseInt(params.place)){case 1:where="tutor";break;case 2:where="client";break;default:where="any"}}if("action"!==key&&"type"!==key&&"google_id"!==key&&"yandex_id"!==key&&"id"!==key&&"hidden_filter"!==key&&value)return parts.push(key+"="+value)}),parts.join("_")},this.updateCookie=function(params){return void 0===this.cookie&&(this.cookie={}),$.each(params,function(_this){return function(key,value){return _this.cookie[key]=value}}(this)),$.cookie("stream",JSON.stringify(this.cookie),{expires:365,path:"/"})},this.initCookie=function(){return void 0!==$.cookie("stream")?this.cookie=JSON.parse($.cookie("stream")):this.updateCookie({step:0,search:0})},this.run=function(action,type,additional){return null==additional&&(additional={}),void 0===this.cookie&&this.initCookie(),this.initialized?this._run(action,type,additional):$timeout(function(_this){return function(){return _this._run(action,type,additional)}}(this),1e3)},this._run=function(action,type,additional){var params;return null==additional&&(additional={}),this.updateCookie({step:this.cookie.step+1}),params={action:action,type:type,step:this.cookie.step,mobile:"undefined"==typeof isMobile?"0":"1"},$.each(additional,function(_this){return function(key,value){return params[key]=value}}(this)),"page"!==action&&dataLayerPush({event:"configuration",eventCategory:action,eventAction:type}),Stream.save(params).$promise},this})}.call(this);