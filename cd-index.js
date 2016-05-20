function closeFlag(flag)
{
	if (flag.hasClass("flag") == false)
		flag = flag.parents("li:first").children(".flag:first");
	
	flag.html("[+]");
	flag.addClass("hidden");
	flag.parents("li:first").children("ul").hide();
}
function openFlag(flag)
{
	if (flag.hasClass("flag") == false)
		flag = flag.parents("li:first").children(".flag:first");
	
	flag.html("[-]");
	flag.removeClass("hidden");
	flag.parents("li:first").children("ul").show();
}

function search()
{
	var keyword = $('input:text.keyword').val();
	keyword = $.trim(keyword);
	if (keyword == "")
		return;
	$(".search-complete").hide();
	$("ul:not(.root-dir)").hide();
	$(".flag").html("[+]").addClass("hidden");
	$(".found").removeClass("found");
	
	var names = $(".root-dir span.name");
	
	$(".counter-label").show();
	$(".counter-all").html(names.length);
	
	var check = function (names, i) {
		if (i < names.length)
		{
			$(".counter-now").html(i+1);
			var n = names.eq(i);
			var name = n.html();
			
			if (name.indexOf(keyword) > -1)
			{
				n.addClass("found");
				
				//打開目錄
				//n.parents("ul").show();
				showDir(n);
			}
			i++;
			setTimeout(function () {
				check(names, i);
			}, 1);
		}
		else
		{
			$(".counter-label").hide();
			$(".search-complete").show();
		}
	};
	
	check(names, 0);
}

$(function () {
	var names = $(".root-dir span");
	names.click(function () {
		var name = $(this);
		var ul = name.parents("li:first").children("ul");
		var flag = name.parents("li:first").children("span.flag");
		if (ul.length > 0)
		{
			//ul.toggle();
			
			if (flag.hasClass("hidden") == false)
				closeFlag(flag);
			else
				openFlag(flag);
		}
	});
	
	
	var found = $(".found");
	for (var i = 0; i < found.length; i++)
	{
		showDir(found.eq(i));
	}
	if (found.length > 0)
	{
		$(".search-match").html(found.length);
		$(".search-complete").show();
	}
	
});

function showDir(node)
{
	var uls = node.parents("ul");
	for (var i = 0; i < uls.length; i++)
	{
		var u = uls.eq(i);
		//u.show();
		var flag = u.prevAll(".flag");
		openFlag(flag);
	}
}
