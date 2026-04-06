<?php

namespace Database\Seeders;

use App\Enums\EvidenceStat;
use App\Enums\IncidentType;
use App\Enums\RepairedStat;
use App\Enums\Severity;
use App\Enums\TypeTest;
use App\Models\Application;
use App\Models\Incident;
use App\Models\Pentest;
use App\Models\User;
use App\Models\Vulnerability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@security.local',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $user1 = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@security.local',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $user2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@security.local',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $programmer1 = User::create([
            'name'     => 'Rizky Pratama',
            'email'    => 'rizky@security.local',
            'password' => Hash::make('password'),
            'role'     => 'programmer',
        ]);

        $programmer2 = User::create([
            'name'     => 'Dewi Lestari',
            'email'    => 'dewi@security.local',
            'password' => Hash::make('password'),
            'role'     => 'programmer',
        ]);

        $programmer3 = User::create([
            'name'     => 'Andi Wijaya',
            'email'    => 'andi@security.local',
            'password' => Hash::make('password'),
            'role'     => 'programmer',
        ]);

        $app1 = Application::create(['application_name' => 'SIMRS - Sistem Informasi Manajemen RS', 'programmer_id' => $programmer1->id]);
        $app2 = Application::create(['application_name' => 'Portal Karyawan Internal',              'programmer_id' => $programmer2->id]);
        $app3 = Application::create(['application_name' => 'Aplikasi Keuangan & Akuntansi',         'programmer_id' => $programmer1->id]);
        $app4 = Application::create(['application_name' => 'E-Procurement System',                  'programmer_id' => $programmer3->id]);
        $app5 = Application::create(['application_name' => 'Dashboard Monitoring Jaringan',         'programmer_id' => $programmer2->id]);

        $vulnPool = [
            ['SQL Injection',                               Severity::Critical->value],
            ['Cross-Site Scripting (XSS)',                  Severity::High->value],
            ['Broken Authentication',                       Severity::High->value],
            ['Sensitive Data Exposure',                     Severity::Medium->value],
            ['XML External Entities (XXE)',                 Severity::High->value],
            ['Security Misconfiguration',                   Severity::Medium->value],
            ['Insecure Deserialization',                    Severity::Critical->value],
            ['Using Components with Known Vulnerabilities', Severity::Low->value],
            ['CSRF Token Missing',                          Severity::Medium->value],
            ['Open Redirect',                               Severity::Low->value],
            ['Directory Traversal',                         Severity::High->value],
            ['Server-Side Request Forgery (SSRF)',          Severity::Critical->value],
            ['Weak Password Policy',                        Severity::Low->value],
            ['Insecure Direct Object Reference (IDOR)',     Severity::High->value],
            ['Missing Rate Limiting',                       Severity::Info->value],
            ['Clickjacking',                                Severity::Low->value],
            ['Unrestricted File Upload',                    Severity::High->value],
            ['Information Disclosure',                      Severity::Info->value],
            ['Business Logic Vulnerability',                Severity::Medium->value],
            ['Path Traversal',                              Severity::High->value],
        ];

        $pentestsData = [
            [$app1->id, TypeTest::Pentest->value, '2023-02-14', RepairedStat::Selesai->value, '2023-03-01'],
            [$app2->id, TypeTest::Pentest->value, '2023-05-20', RepairedStat::Selesai->value, '2023-06-15'],
            [$app3->id, TypeTest::VA->value,      '2023-08-10', RepairedStat::Proses->value,  null],
            [$app4->id, TypeTest::Pentest->value, '2023-11-05', RepairedStat::Selesai->value, '2023-12-01'],
            [$app5->id, TypeTest::VA->value,      '2024-01-18', RepairedStat::Belum->value,   null],
            [$app1->id, TypeTest::Pentest->value, '2024-03-22', RepairedStat::Selesai->value, '2024-04-20'],
            [$app2->id, TypeTest::VA->value,      '2024-06-07', RepairedStat::Proses->value,  null],
            [$app3->id, TypeTest::Pentest->value, '2024-08-30', RepairedStat::Belum->value,   null],
            [$app4->id, TypeTest::VA->value,      '2024-10-14', RepairedStat::Selesai->value, '2024-11-10'],
            [$app5->id, TypeTest::Pentest->value, '2025-01-09', RepairedStat::Proses->value,  null],
            [$app1->id, TypeTest::Pentest->value, '2025-03-03', RepairedStat::Belum->value,   null],
            [$app2->id, TypeTest::VA->value,      '2025-05-19', RepairedStat::Belum->value,   null],
        ];

        foreach ($pentestsData as [$appId, $type, $date, $repairedStatus, $repairedDate]) {
            $pentest = Pentest::create([
                'application_id'  => $appId,
                'type'            => $type,
                'pentest_date'    => $date,
                'repaired_status' => $repairedStatus,
                'repaired_date'   => $repairedDate,
                'created_by'      => $admin->id,
            ]);

            $picked = collect($vulnPool)->shuffle()->take(rand(2, 5));
            foreach ($picked as [$vulnName, $severity]) {
                Vulnerability::create([
                    'pentest_id'         => $pentest->id,
                    'vulnerability_name' => $vulnName,
                    'severity'           => $severity,
                ]);
            }

            $programmer = User::find(Application::find($appId)->programmer_id);

            if ($repairedStatus === RepairedStat::Selesai->value) {
                $pentest->evidences()->create([
                    'uploaded_by'   => $programmer->id,
                    'uploader_role' => 'programmer',
                    'file_path'     => 'evidences/pentests/' . $pentest->id . '/bukti_' . $date . '.pdf',
                    'file_name'     => 'laporan_' . $date . '.pdf',
                    'status'        => EvidenceStat::Approved->value,
                    'approved_by'   => $admin->id,
                    'approved_at'   => now(),
                ]);
            }

            if (in_array($repairedStatus, [RepairedStat::Proses->value, RepairedStat::Selesai->value])) {
                $uploader = rand(0, 1) ? $user1 : $user2;
                $pentest->evidences()->create([
                    'uploaded_by'   => $uploader->id,
                    'uploader_role' => 'user',
                    'file_path'     => 'evidences/pentests/' . $pentest->id . '/laporan_' . $date . '.pdf',
                    'file_name'     => 'laporan_' . $date . '.pdf',
                    'status'        => $repairedStatus === RepairedStat::Selesai->value
                                        ? EvidenceStat::Approved->value
                                        : EvidenceStat::Pending->value,
                    'approved_by'   => $repairedStatus === RepairedStat::Selesai->value ? $admin->id : null,
                    'approved_at'   => $repairedStatus === RepairedStat::Selesai->value ? now() : null,
                ]);
            }
        }

        $incidents = [
            [
                'app_id'          => $app1->id,
                'type'            => IncidentType::PotensiInsiden->value,
                'reporter_name'   => null,
                'pic_id'          => $programmer1->id,
                'date'            => '2023-03-10',
                'vuln'            => 'SQL Injection pada Form Login',
                'severity'        => Severity::Critical->value,
                'repaired_status' => RepairedStat::Belum->value,
                'repaired_date'   => null,
                'created_by'      => $user1->id,
            ],
            [
                'app_id'          => $app2->id,
                'type'            => IncidentType::PotensiInsiden->value,
                'reporter_name'   => null,
                'pic_id'          => $programmer2->id,
                'date'            => '2023-06-18',
                'vuln'            => 'XSS pada Halaman Profil',
                'severity'        => Severity::High->value,
                'repaired_status' => RepairedStat::Proses->value,
                'repaired_date'   => null,
                'created_by'      => $user2->id,
            ],
            [
                'app_id'          => $app3->id,
                'type'            => IncidentType::LaporanMasyarakat->value,
                'reporter_name'   => 'Ahmad Fauzi',
                'pic_id'          => $programmer1->id,
                'date'            => '2023-09-05',
                'vuln'            => 'Data Keuangan Bocor',
                'severity'        => Severity::Critical->value,
                'repaired_status' => RepairedStat::Selesai->value,
                'repaired_date'   => '2023-09-25',
                'created_by'      => $admin->id,
            ],
            [
                'app_id'          => $app4->id,
                'type'            => IncidentType::LaporanMasyarakat->value,
                'reporter_name'   => 'Maya Sari',
                'pic_id'          => $programmer3->id,
                'date'            => '2023-11-20',
                'vuln'            => 'Akses Tidak Terotorisasi',
                'severity'        => Severity::High->value,
                'repaired_status' => RepairedStat::Belum->value,
                'repaired_date'   => null,
                'created_by'      => $admin->id,
            ],
            [
                'app_id'          => $app5->id,
                'type'            => IncidentType::PotensiInsiden->value,
                'reporter_name'   => null,
                'pic_id'          => $programmer2->id,
                'date'            => '2024-01-28',
                'vuln'            => 'Brute Force Attack',
                'severity'        => Severity::Medium->value,
                'repaired_status' => RepairedStat::Proses->value,
                'repaired_date'   => null,
                'created_by'      => $user1->id,
            ],
            [
                'app_id'          => $app1->id,
                'type'            => IncidentType::LaporanMasyarakat->value,
                'reporter_name'   => 'Hendra Gunawan',
                'pic_id'          => $programmer1->id,
                'date'            => '2024-03-14',
                'vuln'            => 'CSRF Vulnerability',
                'severity'        => Severity::Medium->value,
                'repaired_status' => RepairedStat::Belum->value,
                'repaired_date'   => null,
                'created_by'      => $admin->id,
            ],
            [
                'app_id'          => $app2->id,
                'type'            => IncidentType::PotensiInsiden->value,
                'reporter_name'   => null,
                'pic_id'          => $programmer2->id,
                'date'            => '2024-05-07',
                'vuln'            => 'Weak Password Policy',
                'severity'        => Severity::Low->value,
                'repaired_status' => RepairedStat::Selesai->value,
                'repaired_date'   => '2024-05-25',
                'created_by'      => $user2->id,
            ],
            [
                'app_id'          => $app3->id,
                'type'            => IncidentType::PotensiInsiden->value,
                'reporter_name'   => null,
                'pic_id'          => $programmer1->id,
                'date'            => '2024-07-11',
                'vuln'            => 'Insecure Direct Object Reference (IDOR)',
                'severity'        => Severity::High->value,
                'repaired_status' => RepairedStat::Belum->value,
                'repaired_date'   => null,
                'created_by'      => $user1->id,
            ],
            [
                'app_id'          => $app4->id,
                'type'            => IncidentType::LaporanMasyarakat->value,
                'reporter_name'   => 'Rina Kusuma',
                'pic_id'          => $programmer3->id,
                'date'            => '2024-09-03',
                'vuln'            => 'Server-Side Request Forgery (SSRF)',
                'severity'        => Severity::Critical->value,
                'repaired_status' => RepairedStat::Proses->value,
                'repaired_date'   => null,
                'created_by'      => $admin->id,
            ],
            [
                'app_id'          => $app5->id,
                'type'            => IncidentType::LaporanMasyarakat->value,
                'reporter_name'   => 'Doni Setiawan',
                'pic_id'          => $programmer2->id,
                'date'            => '2024-10-22',
                'vuln'            => 'Directory Traversal',
                'severity'        => Severity::High->value,
                'repaired_status' => RepairedStat::Selesai->value,
                'repaired_date'   => '2024-11-05',
                'created_by'      => $user2->id,
            ],
            [
                'app_id'          => $app1->id,
                'type'            => IncidentType::PotensiInsiden->value,
                'reporter_name'   => null,
                'pic_id'          => $programmer1->id,
                'date'            => '2025-01-15',
                'vuln'            => 'Unrestricted File Upload',
                'severity'        => Severity::Critical->value,
                'repaired_status' => RepairedStat::Belum->value,
                'repaired_date'   => null,
                'created_by'      => $user1->id,
            ],
            [
                'app_id'          => $app2->id,
                'type'            => IncidentType::LaporanMasyarakat->value,
                'reporter_name'   => 'Fajar Nugroho',
                'pic_id'          => $programmer2->id,
                'date'            => '2025-02-28',
                'vuln'            => 'Information Disclosure',
                'severity'        => Severity::Info->value,
                'repaired_status' => RepairedStat::Proses->value,
                'repaired_date'   => null,
                'created_by'      => $admin->id,
            ],
            [
                'app_id'          => $app3->id,
                'type'            => IncidentType::PotensiInsiden->value,
                'reporter_name'   => null,
                'pic_id'          => $programmer1->id,
                'date'            => '2025-04-10',
                'vuln'            => 'Business Logic Vulnerability',
                'severity'        => Severity::Medium->value,
                'repaired_status' => RepairedStat::Belum->value,
                'repaired_date'   => null,
                'created_by'      => $user2->id,
            ],
        ];

        foreach ($incidents as $data) {
            $ticketCode = 'TIK-' . strtoupper(substr(str_replace('-', '', \Illuminate\Support\Str::uuid()->toString()), 0, 12));
            $incident = Incident::create([
                'ticket_code'        => $ticketCode,
                'application_id'     => $data['app_id'],
                'type'               => $data['type'],
                'reporter_name'      => $data['reporter_name'],
                'pic_id'             => $data['pic_id'],
                'reporting_date'     => $data['date'],
                'vulnerability_name' => $data['vuln'],
                'severity'           => $data['severity'],
                'repaired_status'    => $data['repaired_status'],
                'repaired_date'      => $data['repaired_date'],
                'created_by'         => $data['created_by'],
            ]);

            $programmer = User::find(Application::find($data['app_id'])->programmer_id);

            if ($data['repaired_status'] === RepairedStat::Selesai->value) {
                $incident->evidences()->create([
                    'uploaded_by'   => $programmer->id,
                    'uploader_role' => 'programmer',
                    'file_path'     => 'evidences/incidents/' . $incident->id . '/bukti_' . $incident->ticket_code . '.pdf',
                    'file_name'     => 'laporan_' . $incident->ticket_code . '.pdf',
                    'status'        => EvidenceStat::Approved->value,
                    'approved_by'   => $admin->id,
                    'approved_at'   => now(),
                ]);
            }

            if (in_array($data['repaired_status'], [RepairedStat::Proses->value, RepairedStat::Selesai->value])) {
                $uploader = rand(0, 1) ? $user1 : $user2;
                $incident->evidences()->create([
                    'uploaded_by'   => $uploader->id,
                    'uploader_role' => 'user',
                    'file_path'     => 'evidences/incidents/' . $incident->id . '/laporan_' . $incident->ticket_code . '.pdf',
                    'file_name'     => 'laporan_' . $incident->ticket_code . '.pdf',
                    'status'        => $data['repaired_status'] === RepairedStat::Selesai->value
                                        ? EvidenceStat::Approved->value
                                        : EvidenceStat::Pending->value,
                    'approved_by'   => $data['repaired_status'] === RepairedStat::Selesai->value ? $admin->id : null,
                    'approved_at'   => $data['repaired_status'] === RepairedStat::Selesai->value ? now() : null,
                ]);
            }
        }

        // News::create([
        //     'title'   => 'MK Ikuti VVIP Program BSSN untuk Penguatan Keamanan Aplikasi',
        //     'slug'    => Str::slug('MK Ikuti VVIP Program BSSN untuk Penguatan Keamanan Aplikasi'),
        //     'image'   => 'assets/images/banner/landing1.png',
        //     'content' => '
        //         <p>Mahkamah Konstitusi melalui PUSTIK MK berpartisipasi dalam Voluntary Vulnerability Identification and Protection Program (VVIP Program) Tahun 2025 yang diselenggarakan oleh Badan Siber dan Sandi Negara (BSSN). Program ini merupakan inisiatif kolaboratif yang melibatkan instansi pemerintah dan komunitas bug hunter untuk mengidentifikasi serta memperbaiki kerentanan aplikasi secara legal, terstruktur, dan terjadwal.</p>
        //         <p><b>Kolaborasi Strategis</b></p>
        //         <p>Melalui program ini, MK memperoleh laporan kerentanan lebih awal beserta rekomendasi teknis perbaikan dari komunitas bug hunter. Hasil ini tidak hanya memperkuat keamanan sistem elektronik di lingkungan MK, tetapi juga menegaskan pentingnya kolaborasi antara instansi pemerintah, BSSN, dan komunitas keamanan siber dalam membangun ekosistem digital yang lebih aman.</p>
        //         <p><b>Paparan Hasil</b></p>
        //         <p>Kegiatan paparan hasil VVIP Program digelar pada 19 September 2025 di Gedung BSSN Ragunan, dihadiri oleh perwakilan instansi peserta. Dalam forum ini, BSSN menyampaikan temuan serta rekomendasi hasil pengujian, sekaligus menekankan perlunya respons cepat terhadap kerentanan agar tidak dieksploitasi pihak tidak bertanggung jawab.</p>
        //         <p><b>Penutup</b></p>
        //         <p>Dengan keterlibatannya dalam VVIP Program, MK menunjukkan komitmen dalam memperkuat keamanan aplikasi strategis dan mendukung agenda nasional ketahanan siber, khususnya di sektor pelayanan publik dan pemerintahan.</p>
        //     ',
        // ]);

        // News::create([
        //     'title'   => 'Benchmarking Kementerian Agama ke PUSTIK Mahkamah Konstitusi: Penguatan Pengelolaan TIK dan CSIRT',
        //     'slug'    => Str::slug('Benchmarking Kementerian Agama ke PUSTIK Mahkamah Konstitusi: Penguatan Pengelolaan TIK dan CSIRT'),
        //     'image'   => 'assets/images/banner/landing2.jpg',
        //     'content' => '
        //         <p>Pusat Data dan Teknologi Informasi Kementerian Agama melakukan kunjungan benchmarking ke Pusat Teknologi Informasi dan Komunikasi (PUSTIK) Mahkamah Konstitusi. Kegiatan ini bertujuan untuk memperkuat pengelolaan Teknologi Informasi dan Komunikasi (TIK) sekaligus menggali pengalaman MK dalam membangun sistem keamanan siber melalui MK-CSIRT.</p>
        //         <p><b>Fokus Benchmarking</b></p>
        //         <p>Dalam agenda kunjungan, tim Kementerian Agama berdiskusi langsung terkait tata kelola TIK di MK, mencakup pengelolaan Data Center, NOC, SOC, Internet dan Jaringan, aplikasi internal, serta layanan helpdesk. PUSTIK MKRI juga memaparkan strategi transformasi digital, mulai dari digitalisasi layanan, integrasi kecerdasan buatan (AI), hingga penguatan keamanan siber melalui IDS, EDR, penetration testing, dan threat hunting.</p>
        //         <p><b>Inovasi LINTANG dan Ketertarikan Kemenag</b></p>
        //         <p>Salah satu sorotan utama adalah presentasi inovasi sistem LINTANG (Live Intelligence Notification for Threat Awareness and Guarding), sebuah sistem deteksi dini ancaman siber real-time dengan dashboard interaktif. Tim Kementerian Agama menyampaikan apresiasi dan ketertarikan untuk mengadopsi LINTANG guna memperkuat pertahanan siber di lingkungan Kemenag.</p>
        //         <p><b>Arah Kolaborasi</b></p>
        //         <p>Selain itu, pertemuan ini juga membahas potensi kolaborasi teknis antar-institusi, terutama dalam interoperabilitas aplikasi dan standardisasi keamanan data. Kedua pihak sepakat melanjutkan koordinasi teknis sebagai tindak lanjut, khususnya untuk menjajaki implementasi sistem keamanan siber secara lebih luas di Kemenag.</p>
        //         <p><b>Dokumentasi Kegiatan</b></p>
        //         <p>Pertemuan berlangsung di Ruang Rapat Gedung 3 Lantai 8 MKRI dan dipimpin langsung oleh Kepala PUSTIK MK. Suasana diskusi yang produktif terlihat dalam dokumentasi kegiatan, di mana kedua tim aktif bertukar pengalaman serta strategi pengelolaan TIK dan keamanan siber.</p>
        //     ',
        // ]);

        // News::create([
        //     'title'   => 'MK Hadiri Seminar Internasional "Cybersecurity for Indonesia\'s Public Sector"',
        //     'slug'    => Str::slug('MK Hadiri Seminar Internasional Cybersecurity for Indonesias Public Sector'),
        //     'image'   => 'assets/images/banner/landing3.png',
        //     'content' => '
        //         <p>Mahkamah Konstitusi melalui Pusat Teknologi Informasi dan Komunikasi (PUSTIK MK) menghadiri seminar internasional bertajuk "Cybersecurity for Indonesia\'s Public Sector: Securing Indonesia\'s Digital Economy & Public Services" yang diselenggarakan oleh Kedutaan Besar Amerika Serikat bekerja sama dengan Fortinet di Hotel Fairmont Jakarta.</p>
        //         <p><b>Peserta dari MK</b></p>
        //         <p>Dalam kegiatan ini, MK diwakili oleh Nanang Subekti (Kepala Pusat TIK) dan Rico Setyawan (Penelaah Teknis Kebijakan).</p>
        //         <p><b>Rangkaian Acara</b></p>
        //         <p>Seminar dibuka oleh Mr. Eric Hsu, Counselor for Commercial Affairs US Embassy Jakarta. Dilanjutkan dengan keynote speech oleh Edwin Lim (Country Director Fortinet Indonesia), Edwin Hidayat Abdullah (Dirjen Ekosistem Digital Komdigi), serta Hartato (Senior Consultant Fortinet Indonesia).</p>
        //         <p><b>Topik dan Pembahasan</b></p>
        //         <p>Dalam sesi pemaparan, para pembicara menekankan pentingnya arsitektur keamanan siber modern yang adaptif, pemanfaatan Artificial Intelligence (AI) dalam sistem pertahanan digital, serta ancaman baru seperti fileless malware. Panel diskusi juga menyoroti tren anomali keamanan siber di Indonesia yang mencapai lebih dari 3 miliar kasus sepanjang Januari–Juli 2025, dengan malware sebagai jenis ancaman terbanyak.</p>
        //         <p><b>Penutup</b></p>
        //         <p>Partisipasi MK dalam forum internasional ini menjadi bagian penting dari upaya memperkuat wawasan dan jejaring dalam bidang keamanan siber, khususnya di sektor publik. Melalui kolaborasi dengan pemangku kepentingan global, MK berkomitmen untuk terus meningkatkan resiliensi siber dalam mendukung penyelenggaraan layanan publik yang aman dan andal.</p>
        //     ',
        // ]);
    }
}
