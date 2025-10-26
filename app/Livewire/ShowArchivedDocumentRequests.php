<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CedulaRequest;
use App\Models\ClearanceRequest;
use App\Models\IndigencyRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class ShowArchivedDocumentRequests extends Component
{
    use WithPagination;

    public int $page = 1;
    // protected string $paginationTheme = 'tailwind';
    protected $queryString = ['page'];

    public function render()
    {
        // ✅ Fetch completed/rejected requests per document
        $cedula = CedulaRequest::whereIn('status', ['Completed', 'Rejected'])
            ->get()
            ->map(function ($item) {
                $item->document_type = 'cedula';
                return $item;
            });

        $clearance = ClearanceRequest::whereIn('status', ['Completed', 'Rejected'])
            ->get()
            ->map(function ($item) {
                $item->document_type = 'clearance';
                return $item;
            });

        $indigency = IndigencyRequest::whereIn('status', ['Completed', 'Rejected'])
            ->get()
            ->map(function ($item) {
                $item->document_type = 'indigency';
                return $item;
            });

        // ✅ Merge and sort all
        $merged = $cedula
            ->merge($clearance)
            ->merge($indigency)
            ->sortByDesc('updated_at')
            ->values();

        // ✅ Manual pagination (similar to Livewire paginate)
        $page = $this->page;
        $perPage = 10;

        $paginated = (new LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        ));

        // ✅ Apply consistent formatting
        $paginated->getCollection()->transform(function ($item) {
            $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y');
            $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A');
            $item->formatted_birthdate = $item->birthdate
                ? Carbon::parse($item->birthdate)->format('F d, Y')
                : null;
            return $item;
        });

        // ✅ Return view
        return view('livewire.show-archived-document-requests', [
            'mergedRequests' => $paginated,
        ]);
    }
}
