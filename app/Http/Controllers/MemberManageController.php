<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class MemberManageController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('member.index', compact('members'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function setting()
    {
        return view('member.setting');
    }

    public function updateSetting(Request $request)
    {
        if ($request->hasFile('logo')) {
            $request->file('logo')->move(public_path('img'), 'logo.png');
        }

        if ($request->hasFile('background')) {
            $request->file('background')->move(public_path('img'), 'bg-kartu.png');
        }

        return redirect()->route('member.index')->with('success', 'Pengaturan kartu berhasil diperbarui.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $members = Member::where('nama', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->orWhere('no_hp', 'LIKE', "%$query%")
            ->orWhere('alamat', 'LIKE', "%$query%")
            ->get();

        $output = '';
        foreach ($members as $member) {
            $output .= '
        <tr>
            <td>' . $member->nama . '</td>
            <td>' . ($member->email ?? '-') . '</td>
            <td>' . $member->no_hp . '</td>
            <td>' . \Str::limit($member->alamat, 50) . '</td>
            <td>
                <a href="' . route('member.edit', $member->id) . '" class="btn btn-icons btn-rounded btn-secondary" title="Edit">
                    <i class="mdi mdi-pencil"></i>
                </a>
                <form action="' . route('member.destroy', $member->id) . '" method="POST" style="display:inline">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-icons btn-rounded btn-secondary ml-1" onclick="return confirm(\'Yakin ingin menghapus member ini?\')" title="Hapus">
                        <i class="mdi mdi-close"></i>
                    </button>
                </form>
                <a href="' . route('member.cetak', $member->id) . '" target="_blank" class="btn btn-icons btn-rounded btn-primary ml-1" title="Cetak Kartu">
                    <i class="mdi mdi-printer"></i>
                </a>
            </td>
        </tr>';
        }

        return response()->json($output);
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
        ]);

        Member::create($request->all());
        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $member->update($request->all());
        return redirect()->route('member.index')->with('success', 'Data member diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('member.index')->with('success', 'Member dihapus.');
    }

    public function cetak($id)
    {
        $member = Member::findOrFail($id);
        $pdf = PDF::loadView('member.cetak', compact('member'))
            ->setPaper([0, 0, 260, 360], 'landscape');
        return $pdf->stream("kartu-member-{$member->id}.pdf");
    }

}
