(function ($) {
  $.fn.formRowDuplicator = function () {
    var mainObj = this; // Main object reference

    var methods = {
      init: function () {
        //console.log("The Plugin Has Been Initialized");
      },

      isAddBtn: function () {
        return $(this).each(function () {
          if ($(this).hasClass("btn-add")) {
            $(this)
              .off("click")
              .on("click", function () {
                methods.duplicateRow.call(this);
              });
          }
        });
      },

      duplicateRow: function () {
        return $(this).each(function () {
          var parent = $(this).closest(".row");
          var html = $(parent).prop("outerHTML");
          var newRow = $(html).insertAfter(parent);

          methods.indexNames.call(mainObj); // Update names for duplicated rows

          // Add new event listener to the duplicated "Add" button
          $(newRow)
            .find(".btn-add")
            .off("click")
            .on("click", function () {
              methods.duplicateRow.call(this);
            });
          // Change "Add" button to "Delete" button functionality
          $(this)
            .removeClass("btn-add btn-success")
            .addClass("btn-delete btn-danger")
            .html('<i class="fa fa-minus"></i>')
            .off("click")
            .on("click", function () {
              methods.deleteRow.call(this);
            });
        });
      },

      deleteRow: function () {
        return $(this).each(function () {
          var parent = $(this).closest(".duplicate");
          $(parent).remove();
          methods.indexNames.call(mainObj); // Reindex names after deletion
        });
      },

      indexNames: function () {
        var duplicates = $(mainObj).find(".duplicate");

        // If only one duplicate, set the name without an array (single entry)
        if (duplicates.length === 1) {
          $(this).attr("name", $(this).data("name"));
          return;
        }

        // Otherwise, set up names for arrays on inputs/selects
        $(duplicates).each(function (index) {
          var inputs = $(this).find("input, select, textarea");
          $(inputs).each(function () {
            var prefix = $(this).data("prefix");
            var name = $(this).data("name");
            var newName = prefix
              ? `${prefix}[${index}][${name}]`
              : `${name}[${index}]`;
            $(this).attr("name", newName);
          });
        });
      },
    };

    // Initialize the plugin for each matching element
    this.each(function () {
      var $this = $(this);

      // Call the init method to log 'The Plugin Has Been Initialized'
      methods.init.call($this);

      $this.find("button").each(function () {
        methods.isAddBtn.call(this);
      });

      // Call indexNames to set up the initial name attributes for any pre-existing rows
      methods.indexNames.call($this);
    });
  };
})(jQuery);
