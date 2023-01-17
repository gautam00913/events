    <legend>Billet n° {{ $i }}</legend>
    <div class="tickets">
        <div class="my-3 flex items-center">
            <x-label  for="ticket_name_{{ $i }}" class="mr-3">
                Nom du billet <span class='text-red-600'>*</span>
            </x-label>
           <div class="flex-1 flex">
            <x-select id="ticket_name_{{ $i }}" name="ticket_name[]" class="flex-1 rounded-md rounded-r-none border-r-0 tickets_option" required>
                ${select.innerHTML}
            </x-select>
            <button data-id="ticket_name_{{ $i }}" type="button" class="text-black border rounded-l-none rounded-md border-gray-300 addTicketBtn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>
            </button>
           </div>
        </div>
        <div class="my-3">
            <x-label  for="ticket_price_{{ $i }}">
                Prix unitaire <span class='text-red-600'>*</span>
            </x-label>
            <x-input id="ticket_price_{{ $i }}" name="ticket_price[]" class="w-full" type="number" required min="0"/>
          
        </div>
        <div class="my-3">
            <x-label  for="ticket_place_{{ $i }}">
                Nombre de place réservé <span class='text-red-600'>*</span>
            </x-label>
            <x-input id="ticket_place_{{ $i }}" name="ticket_place[]" class="w-full" type="number" required min="0"/>
          
        </div>
    </div>

    <script>
        addTicketBtn()
    </script>