@push('javascripts')
{{-- For not Repeating fill --}}
<script>
    document.addEventListener('livewire:load', function () {

      function stopRepeatFill(){
        // Array to store the values from all elements based on their data-index
            var selectedValuesByIndex = {};

            // Select all the select elements with class 'store_fill_id'
            var elements = $('.store_fill_id.select2');

            // Collect the values of all elements grouped by data-index
            elements.each(function() {
            var currentElement = $(this);
            var currentIndex = currentElement.data('index'); // Get the data-index of the current element

            // Initialize the array for this data-index if it doesn't exist
            if (!selectedValuesByIndex[currentIndex]) {
            selectedValuesByIndex[currentIndex] = [];
            }

            var value = currentElement.val();
            if (value) { // Ensure it's not null or empty
            selectedValuesByIndex[currentIndex].push(value); // Store the value for this index
            }
            });

            // Loop through each select element again to remove options based on collected values
            elements.each(function() {
            var currentElement = $(this);
            var currentIndex = currentElement.data('index'); // Get the data-index of the current element
            var currentValue = currentElement.val(); // Get the value of the current select element

            // Loop through the options of the current select element
            currentElement.find('option').each(function() {
            var optionValue = $(this).val();

            // Remove the option if it is in selectedValues for this index but not the current element's value
            if (selectedValuesByIndex[currentIndex].includes(optionValue) && optionValue !== currentValue) {
            $(this).remove(); // Remove the option if its value is in the selectedValues for this index
            }
            });

            var basic_unit_variations_count = @this.get('basic_unit_variations_count');



            // Refresh Select2 to apply the changes
            currentElement.trigger('change.select2');
            parentContainer = currentElement.closest('.fill-stores-data-container');

            if (parentContainer.length) {
            var childCount = parentContainer.find('.bg-light').length;


            if(childCount == basic_unit_variations_count){
            $('.add-store-data-btn[data-index="' + currentIndex + '"]').prop('disabled', true);
            }else{
            $('.add-store-data-btn[data-index="' + currentIndex + '"]').prop('disabled', false);
            }
            }
            });
      }

      stopRepeatFill()
        // Hook into Livewire's lifecycle to reapply JS changes after any Livewire updates
        Livewire.hook('message.processed', (message, component) => {
stopRepeatFill()

        });
    });
</script>

{{-- For Not Repeating Stores --}}
<script>
    document.addEventListener('livewire:load', function () {

        function stopRepeatStores(){
            var fill_stores_count = @this.get('fill_stores_count');

                var stores_count = @this.get('stores_count')

                if(fill_stores_count == stores_count -1){

                $('.add-store-btn').prop('disabled', true);
                }else{
                $('.add-store-btn').prop('disabled', false);
                }

                // Array to store the values from all the elements
                var selectedValues = [];

                // Select all the select elements with class 'store_fill_id' and data-index equal to event.detail.index
                var elements = $('.all_stores.select2');

                // Collect the values of all elements
                elements.each(function() {
                var value = $(this).val();
                if (value) { // Ensure it's not null or empty
                selectedValues.push(value);
                }
                });

                // Loop through each select element
                elements.each(function() {
                var currentElement = $(this);
                var currentValue = currentElement.val(); // Get the value of the current select element

                // Loop through the options of the current select element
                currentElement.find('option').each(function() {
                var optionValue = $(this).val();

                // Remove the option if it is in selectedValues but not the current element's value
                if (selectedValues.includes(optionValue) && optionValue !== currentValue) {
                $(this).remove(); // Remove the option if its value is in the selectedValues array but not in the current element
                }
                });

                // Refresh Select2 to apply the changes
                currentElement.trigger('change.select2');
                });
        }

        stopRepeatStores()

        // Hook into Livewire's lifecycle to reapply JS changes after any Livewire updates
        Livewire.hook('message.processed', (message, component) => {

stopRepeatStores()
        });
        });

</script>


{{-- For Not Repeating Main fill --}}
<script>
    document.addEventListener('livewire:load', function () {

        function stopRepeatMainFill(){
            var units_count = @this.get('units_count');


            var rows_count = @this.get('rows_count');


            if(rows_count == units_count){
            $('.main-fill-btn').prop('disabled', true);
            }else{
            $('.main-fill-btn').prop('disabled', false);
            }

            // Array to store the values from all the elements
            var selectedValues = [];

            // Select all the select elements with class 'store_fill_id' and data-index equal to event.detail.index
            var elements = $('.main_fill.select2');

            // Collect the values of all elements
            elements.each(function() {
            var value = $(this).val();
            if (value) { // Ensure it's not null or empty
            selectedValues.push(value);
            }
            });

            // Loop through each select element
            elements.each(function() {
            var currentElement = $(this);
            var currentValue = currentElement.val(); // Get the value of the current select element

            // Loop through the options of the current select element
            currentElement.find('option').each(function() {
            var optionValue = $(this).val();

            // Remove the option if it is in selectedValues but not the current element's value
            if (selectedValues.includes(optionValue) && optionValue !== currentValue) {
            $(this).remove(); // Remove the option if its value is in the selectedValues array but not in the current element
            }
            });

            // Refresh Select2 to apply the changes
            currentElement.trigger('change.select2');
            });
        }

        stopRepeatMainFill()

        // Hook into Livewire's lifecycle to reapply JS changes after any Livewire updates
        Livewire.hook('message.processed', (message, component) => {
stopRepeatMainFill()
    });
});
</script>
@endpush
