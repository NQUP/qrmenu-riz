        <footer class="bg-slate-900 text-white py-12 px-6 mt-16 relative z-20">
            <div class="w-full text-center">
                @php
                    $siteName = siteSetting('site_name') ?: 'Nama Usaha';
                    $hours = siteSetting('site_working_hours') ?: 'Belum diatur';
                    $address = siteSetting('site_address') ?: 'Belum diatur';
                    $email = siteSetting('site_email') ?: 'Belum diatur';
                    $orderUrl = url('/pesan');
                @endphp

                <div class="mb-10">
                    <h3 class="text-2xl font-semibold mb-3 tracking-wide">{{ $siteName }}</h3>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        Sejak 2010 kami menghadirkan menu makanan dan minuman terbaik.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                    <div class="flex flex-col items-center">
                        <h3 class="text-sm uppercase tracking-[0.3em] text-slate-400 mb-4">Jam Operasional</h3>
                        <p class="text-slate-200 text-sm leading-relaxed whitespace-pre-line">{{ $hours }}</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <h3 class="text-sm uppercase tracking-[0.3em] text-slate-400 mb-4">Kontak</h3>
                        <div class="space-y-2 text-slate-200 text-sm leading-relaxed">
                            <p>{{ $address }}</p>
                            <p class="break-all">{{ $email }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <h3 class="text-sm uppercase tracking-[0.3em] text-slate-400 mb-4">Ikuti Kami</h3>
                        <div class="flex items-center justify-center space-x-4">
                            <a href="{{ siteSetting('site_instagram_url') }}" class="text-slate-200 hover:text-white transition-colors duration-300">
                                <i class="fa-brands fa-instagram text-xl"></i>
                            </a>
                            <a href="{{ siteSetting('site_facebook_url') }}" class="text-slate-200 hover:text-white transition-colors duration-300">
                                <i class="fa-brands fa-facebook text-xl"></i>
                            </a>
                            <a href="{{ siteSetting('site_twitter_url') }}" class="text-slate-200 hover:text-white transition-colors duration-300">
                                <i class="fa-brands fa-twitter text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex flex-col items-center gap-3">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">QR Pesan</p>
                    <div class="h-24 w-24 rounded-lg border border-slate-700 bg-white p-2">
                        {!! QrCode::size(88)->margin(0)->generate($orderUrl) !!}
                    </div>
                </div>

                <div class="border-t border-slate-700 mt-10 pt-6 text-center text-slate-400 text-sm">
                    <p>© 2025 {{ siteSetting('site_name') }} Hak cipta dilindungi.</p>
                </div>
            </div>
        </footer>
