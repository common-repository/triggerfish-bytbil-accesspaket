window.addEventListener("load", () => {
  const sortable = new Sortable.default(
    document.querySelectorAll(".filter-table > tbody"),
    {
      draggable: ".filter-item",
      handle: ".js-handle-drag",
    }
  );

  sortable.on("sortable:stop", () => {
    Sorter.save();
  });

  ColorPicker.init();
  HeroImage.init();
  FallbackImage.init();
  CarContent.init();
  ArchiveContent.init();
});

var ColorPicker = {
  init: () => {
    jQuery(".tfap-color-field").wpColorPicker({
      palettes: true,
    });

    jQuery(".tfap-text-color-field").wpColorPicker({
      palettes: ["#000", "#fff"],
      change: (event) => console.log(event),
    });

    jQuery(".iris-strip").hide();
    jQuery(".iris-square").css("width", "100%");
  },
};

var Sorter = {
  save: () => {
    setTimeout(() => {
      Sorter.saveFilterSort();
    }, 1000);
  },
  saveFilterSort: () => {
    const elements = document.querySelectorAll(".filter-item");

    let sortOrder = [];

    for (var i = 0; i < elements.length; i++) {
      const element = elements[i];
      const input = element.querySelector("input");

      sortOrder[i] = input.getAttribute("name");
    }

    jQuery.post("/wp-json/accesspackage/v1/saveFilterOrder", {
      data: sortOrder,
    });
  },
};

var HeroImage = {
  init: () => {
    jQuery(".js-tfap-remove-img").click((e) => {
      e.preventDefault();

      jQuery.post(
        "/wp-json/accesspackage/v1/saveHeroImage",
        { id: null },
        function (response) {
          if (response.success === true) {
            jQuery(".js-tfap-image-container img").remove();
            jQuery(".js-tfap-remove-img").addClass("hidden");
          }
        }
      );
    });

    jQuery("#access_package_hero_background_image_manager").click((e) => {
      e.preventDefault();

      var imageFrame;
      if (imageFrame) {
        imageFrame.open();
      }

      imageFrame = wp.media({
        title: "Select Media",
        multiple: false,
        library: {
          type: "image",
        },
      });

      imageFrame.on("close", () => {
        var selection = imageFrame.state().get("selection");
        var id = selection.models[0]["id"];

        if (id) {
          jQuery('input[name="access_package_hero_background_image"]').val(id);
          Refresh_Image(id);
        }
      });

      imageFrame.on("open", () => {
        var selection = imageFrame.state().get("selection");
        var ids = jQuery('input[name="access_package_hero_background_image"]')
          .val()
          .split(",");
        ids.forEach((id) => {
          var attachment = wp.media.attachment(id);
          attachment.fetch();
          selection.add(attachment ? [attachment] : []);
        });
      });

      imageFrame.open();
    });
  },
};

var FallbackImage = {
    init: () => {
      jQuery(".js-tfap-remove-fallback-img").click((e) => {
        e.preventDefault();
  
        jQuery.post(
          "/wp-json/accesspackage/v1/saveFallbackImage",
          { id: null },
          function (response) {
            if (response.success === true) {
              jQuery(".js-tfap-fallback-image-container img").remove();
              jQuery(".js-tfap-remove-fallback-img").addClass("hidden");
            }
          }
        );
      });
  
      jQuery("#access_package_custom_fallback_image_manager").click((e) => {
        e.preventDefault();
        var imageFrame;
        if (imageFrame) {
          imageFrame.open();
        }
  
        imageFrame = wp.media({
          title: "Select Media",
          multiple: false,
          library: {
            type: "image",
          },
        });
  
        imageFrame.on("close", () => {
          var selection = imageFrame.state().get("selection");
          var id = selection.models[0]["id"];
  
          if (id) {
            jQuery('input[name="access_package_custom_fallback_image"]').val(id);
            Refresh_Fallback_Image(id);
          }
        });
  
        imageFrame.on("open", () => {
          var selection = imageFrame.state().get("selection");
          var ids = jQuery('input[name="access_package_custom_fallback_image"]')
            .val()
            .split(",");
          ids.forEach((id) => {
            var attachment = wp.media.attachment(id);
            attachment.fetch();
            selection.add(attachment ? [attachment] : []);
          });
        });
  
        imageFrame.open();
      });
    },
  };

var CarContent = {
  init: () => {
    var editor = jQuery(".js-access-package-single-car-content");

    if (!editor.length) {
      return;
    }

    wp.editor.initialize("access_package_single_car_content", {
      tinymce: {
        wpautop: true,
        plugins:
          "charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview",
        toolbar1:
          "formatselect bold italic | bullist numlist | blockquote | alignleft aligncenter alignright | link unlink | wp_more | spellchecker",
      },
      quicktags: true,
    });
  },
};

var ArchiveContent = {
  init: () => {
    var editor = jQuery(".js-content-before-filters");

    if (!editor.length) {
      return;
    }

    var settings = {
      tinymce: {
        wpautop: true,
        plugins:
          "charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview",
        toolbar1:
          "formatselect bold italic | bullist numlist | blockquote | alignleft aligncenter alignright | link unlink | wp_more | spellchecker",
      },
      quicktags: true,
    };

    if (wp.oldEditor) {
      wp.oldEditor.initialize("tfap_content_before_filters", settings);
    } else {
      wp.editor.initialize("tfap_content_before_filters", settings);
    }
  },
};

function Refresh_Image(id) {
  jQuery.post(
    "/wp-json/accesspackage/v1/saveHeroImage",
    { id: id },
    function (response) {
      if (response.success === true) {
        jQuery(".js-tfap-image-container img").remove();
        jQuery(".js-tfap-image-container").prepend(response.data.image);
        jQuery(".js-tfap-remove-img").removeClass("hidden");
      }
    }
  );
}

function Refresh_Fallback_Image(id) {
    jQuery.post(
      "/wp-json/accesspackage/v1/saveFallbackImage",
      { id: id },
      function (response) {
        if (response.success === true) {
          jQuery(".js-tfap-fallback-image-container img").remove();
          jQuery(".js-tfap-fallback-image-container").prepend(response.data.image);
          jQuery(".js-tfap-remove-fallback-img").removeClass("hidden");
        }
      }
    );
  }
