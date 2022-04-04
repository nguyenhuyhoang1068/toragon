jQuery(document).ready(function(){
  jQuery(document).on("click", ".plus, .minus", function () {
    var t = jQuery(this),
      e = t.closest(".quantity").find(".qty"),
      i = parseFloat(e.val()),
      r = parseFloat(e.attr("max")),
      o = parseFloat(e.attr("min")),
      a = e.attr("step");
    (i && "" !== i && "NaN" !== i) || (i = 0),
      ("" !== r && "NaN" !== r) || (r = ""),
      ("" !== o && "NaN" !== o) || (o = 0),
      ("any" !== a &&
        "" !== a &&
        void 0 !== a &&
        "NaN" !== parseFloat(a)) ||
        (a = 1),
      t.is(".plus")
        ? r && (r === i || i > r)
          ? e.val(r)
          : e.val(i + parseFloat(a))
        : o && (o === i || i < o)
        ? e.val(o)
        : i > 0 && e.val(i - parseFloat(a)),
      e.trigger("change");
  });
});
    
    