<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\QrisService;
use Illuminate\Http\Request;

class QrisGatewayController extends Controller {
    public function index(Request $request) {
        $qrisEnabled = Setting::get('qris_enabled', '1');
        $merchantName = Setting::get('qris_merchant_name', 'KWT ARIYAD JAYA');
        $staticString = Setting::get('qris_static_string', '');
        $buatqrisUrl = Setting::get('buatqris_api_url', 'https://app.buatqris.site/api');

        // Test amount
        $testAmount = (int) $request->get('test_amount', 10000);
        $previewData = null;

        if ($staticString) {
            $previewData = QrisService::getDynamicQrisData($testAmount, $staticString);
        }

        return view('admin.qris.index', compact(
            'qrisEnabled',
            'merchantName',
            'staticString',
            'buatqrisUrl',
            'testAmount',
            'previewData'
        ));
    }

    public function update(Request $request) {
        $request->validate([
            'qris_merchant_name' => 'required|string|max:100',
            'qris_static_string' => 'required|string',
            'buatqris_api_url' => 'nullable|url',
        ]);

        $staticString = trim($request->qris_static_string);

        // Basic validation
        if (!QrisService::isValidQris($staticString)) {
            return back()->with('error', 'String QRIS tidak valid. Pastikan string diawali dengan 000201...')->withInput();
        }

        Setting::set('qris_enabled', $request->has('qris_enabled') ? '1' : '0');
        Setting::set('qris_merchant_name', $request->qris_merchant_name);
        Setting::set('qris_static_string', $staticString);
        Setting::set('buatqris_api_url', $request->buatqris_api_url);

        return back()->with('success', 'Pengaturan QRIS Payment Gateway berhasil diperbarui!');
    }
}

