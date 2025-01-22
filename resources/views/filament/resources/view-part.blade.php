<div>
  <h3 class="text-lg font-bold mb-4">Detail Record</h3>
  <table class="table-auto w-full border-collapse border border-gray-200">
      <tbody>
          @foreach ($record->getAttributes() as $field => $value)
              <tr>
                  <td class="border px-4 py-2 font-semibold">{{ ucwords(str_replace('_', ' ', $field)) }}</td>
                  <td class="border px-4 py-2">{{ $value }}</td>
              </tr>
          @endforeach
      </tbody>
  </table>
</div>
