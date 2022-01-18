<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminFAQRequest;
use App\Models\FAQ;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AdminFAQController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_admin');
    }

    public function index()
    {
        $faqs = FAQ::orderBy('order_num', 'asc')->paginate(10);
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        $latest_faq = FAQ::orderBy('order_num', 'desc')->first();
        $faq = new FAQ();
        $faq->order_num = ($latest_faq) ? $latest_faq->order_num + 1 : 1;
        return view('admin.faq.create', compact('faq'));
    }

    public function store(AdminFAQRequest $request)
    {
        FAQ::create($request->only('title', 'description', 'order_num'));
        return redirect('admin/faq')
            ->with('success', 'New FAQ has been created successfully');
    }

    public function edit($id)
    {
        $faq = FAQ::find($id);

        if (!$faq) {
            return redirect()
                ->back()
                ->with('error', 'FAQ not found');
        }
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(AdminFAQRequest $request, $id)
    {
        $faq = FAQ::find($id);
        if (!$faq) {
            return redirect()
                ->back()
                ->with('error', 'FAQ not found');
        }
        $faq->update($request->only('title', 'description', 'order_num'));
        return redirect()->back()
            ->with('success', 'FAQ updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        $faq = FAQ::find($id);
        if (!$faq) {
            return redirect()
                ->back()
                ->with('error', 'FAQ not found');
        }
        $faq->delete();

        /**Redirect page to correct page*/
        if ($request['page'] > 1) {
            $total_faqs = FAQ::whereRaw('1=1');
            $total_faqs = $total_faqs->count();
            if (ceil($total_faqs / 10) < $request['page']) {
                $request['page'] -= 1;
                $query_items = http_build_query($request->except(10));
                return redirect('admin/faq?' . $query_items)
                    ->with('success', 'FAQ deleted successfully');
            }
        }

        return redirect()
            ->back()
            ->with('success', 'FAQ deleted successfully');
    }
}