<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceReport;
use App\Models\Part;
use App\Models\Customer;
use App\Models\Transaction;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'all');
        $search = $request->input('search');

        $archives = collect();

        if ($type === 'all' || $type === 'services') {
            $services = ServiceReport::onlyTrashed()
                ->when($search, function ($query) use ($search) {
                    $query->where('customer_name', 'like', "%$search%")
                        ->orWhere('id', 'like', "%$search%");
                })
                ->get()
                ->map(function ($item) {
                    $item->type = 'Service Report';
                    $item->details = '#' . $item->id . ' - ' . $item->customer_name;
                    return $item;
                });
            $archives = $archives->merge($services);
        }

        if ($type === 'all' || $type === 'inventory') {
            $parts = Part::onlyTrashed()
                ->when($search, function ($query) use ($search) {
                    $query->where('description', 'like', "%$search%")
                        ->orWhere('part_no', 'like', "%$search%");
                })
                ->get()
                ->map(function ($item) {
                    $item->type = 'Inventory Part';
                    $item->details = $item->part_no . ' - ' . $item->description;
                    return $item;
                });
            $archives = $archives->merge($parts);
        }

        // Add similar logic for Customers and Transactions if needed

        // Pagination (manual)
        $archives = $archives->sortByDesc('deleted_at');
        $perPage = 10;
        $page = $request->input('page', 1);
        $paginatedArchives = new \Illuminate\Pagination\LengthAwarePaginator(
            $archives->forPage($page, $perPage),
            $archives->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('archive.index', compact('paginatedArchives', 'type', 'search'));
    }

    public function restore($type, $id)
    {
        switch ($type) {
            case 'Service Report':
                $item = ServiceReport::onlyTrashed()->find($id);
                break;
            case 'Inventory Part':
                $item = Part::onlyTrashed()->find($id);
                break;
            default:
                return back()->with('error', 'Invalid type');
        }

        if ($item) {
            $item->restore();
            return back()->with('success', 'Record restored successfully.');
        }

        return back()->with('error', 'Record not found.');
    }

    public function destroy($type, $id)
    {
        switch ($type) {
            case 'Service Report':
                $item = ServiceReport::onlyTrashed()->find($id);
                break;
            case 'Inventory Part':
                $item = Part::onlyTrashed()->find($id);
                break;
            default:
                return back()->with('error', 'Invalid type');
        }

        if ($item) {
            $item->forceDelete();
            return back()->with('success', 'Record permanently deleted.');
        }

        return back()->with('error', 'Record not found.');
    }
}
