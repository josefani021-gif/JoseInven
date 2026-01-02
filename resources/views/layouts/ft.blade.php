<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Sistem Inventory') - Manajemen Inventory</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		/* Aesthetic Color Palette - Modern & Clean */
		:root {
			--c1: #6366f1; /* Indigo */
			--c2: #f8fafc; /* Soft white */
			--c3: #ec4899; /* Pink */
			--c4: #14b8a6; /* Teal */
			--c5: #8b5cf6; /* Purple */
			--cream: #fef3c7ff; /* Warm cream */
			--blue: #3b82f6; /* Blue */
		}

		/* Background Gradient - Aesthetic & Modern */
		body.bg-black {
			background: linear-gradient(135deg,
				#f8fafc 0%,
				#f1f5f9 25%,
				#e2e8f0 50%,
				#f1f5f9 75%,
				#f8fafc 100%) !important;
			color: #1e293b !important;
			min-height: 100vh;
			background-attachment: fixed;
			background-size: 400% 400%;
			animation: gradientShift 20s ease infinite;
		}

		@keyframes gradientShift {
			0% { background-position: 0% 50%; }
			50% { background-position: 100% 50%; }
			100% { background-position: 0% 50%; }
		}

		/* Glass Card - Modern Dashboard Cards */
		.glass-card {
			background: linear-gradient(135deg,
				rgba(255, 255, 255, 0.9) 0%,
				rgba(255, 255, 255, 0.95) 100%);
			border: 1px solid rgba(255, 255, 255, 0.4);
			box-shadow:
				0 20px 40px rgba(0, 0, 0, 0.08),
				0 10px 20px rgba(0, 0, 0, 0.04),
				inset 0 1px 0 rgba(255, 255, 255, 0.6);
			backdrop-filter: blur(20px) saturate(180%);
			-webkit-backdrop-filter: blur(20px) saturate(180%);
			border-radius: 20px;
			position: relative;
			overflow: hidden;
			transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
		}

		.glass-card::before { content: ''; position: absolute; inset:0; background: linear-gradient(45deg, transparent 0%, rgba(99,102,241,0.03) 50%, transparent 100%); pointer-events:none; }
		.glass-card::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: linear-gradient(45deg, transparent 30%, rgba(236,72,153,0.05) 50%, transparent 70%); transform: rotate(25deg); animation: shimmer 3s infinite; pointer-events:none; }
		@keyframes shimmer { 0% { transform: translateX(-100%) rotate(25deg); } 100% { transform: translateX(100%) rotate(25deg); } }

		/* Button Styles */
		.btn-blue { background: linear-gradient(135deg, var(--c1), var(--c5)); color: white; padding: 0.75rem 1.5rem; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); width: 100%; }
		.btn-cream { background: linear-gradient(135deg, var(--cream), #fbbf24); color: #1e293b; padding: 0.75rem 1.5rem; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3); width: 100%; }

		/* Small utility overrides for welcome */
		.container { max-width: 1100px; margin: 0 auto; padding: 1rem; }
		main { padding-top: 2rem; padding-bottom: 2rem; }
		footer { text-align:center; padding:2rem 0; color:#6b7280 }
	</style>
</head>
<body class="bg-black text-black">
	<main class="container">
		<!-- Notifications (keep capability if welcome shows flashes) -->
		@if ($errors->any())
			<div class="glass-card mb-6 bg-red-900/60 border border-red-700 px-6 py-4 rounded-xl">
				<strong class="font-semibold">Kesalahan:</strong>
				<ul class="list-disc ml-5 mt-2 space-y-1">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		@if (session('success'))
			<div class="glass-card mb-6 bg-green-900/60 border border-green-700 px-6 py-4 rounded-xl">
				<div class="flex items-center gap-3">
					<x-icon name="check" class="text-xl text-green-300"/>
					<span class="font-medium">{{ session('success') }}</span>
				</div>
			</div>
		@endif

		@if (session('error'))
			<div class="glass-card mb-6 bg-red-900/60 border border-red-700 px-6 py-4 rounded-xl">
				<div class="flex items-center gap-3">
					<x-icon name="close" class="text-xl text-red-300"/>
					<span class="font-medium">{{ session('error') }}</span>
				</div>
			</div>
		@endif

		@yield('content')
	</main>

	<footer>
		<p class="font-medium">&copy; {{ date('Y') }} Sistem Inventory. Hak cipta dilindungi.</p>
					<p class="text-sm opacity-80 mt-2">Version 1.0 | Josep Design</p>
	</footer>

	@stack('scripts')

	<script>
		// Basic UI interactions used by welcome page
		document.addEventListener('DOMContentLoaded', function() {
			// Ripple effect for buttons (used on CTAs)
			document.querySelectorAll('.btn-blue, .btn-cream').forEach(button => {
				button.style.position = 'relative';
				button.addEventListener('click', function(e) {
					let ripple = document.createElement('span');
					let rect = this.getBoundingClientRect();
					let size = Math.max(rect.width, rect.height);
					let x = e.clientX - rect.left - size / 2;
					let y = e.clientY - rect.top - size / 2;

					ripple.style.cssText = `position:absolute;border-radius:50%;background:rgba(255,255,255,0.7);transform:scale(0);animation:ripple 0.6s linear;width:${size}px;height:${size}px;top:${y}px;left:${x}px;pointer-events:none;`;
					this.appendChild(ripple);
					setTimeout(() => ripple.remove(), 600);
				});
			});

			// Animate glass-cards on load
			const cards = document.querySelectorAll('.glass-card');
			cards.forEach((card, index) => {
				card.style.opacity = '0';
				card.style.transform = 'translateY(20px)';
				setTimeout(() => {
					card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
					card.style.opacity = '1';
					card.style.transform = 'translateY(0)';
				}, index * 100);
			});

			// Sections observer for landing page
			try {
				const sections = document.querySelectorAll('section');
				if (sections.length) {
					const observer = new IntersectionObserver((entries) => {
						entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
					}, { threshold: 0.1 });
					sections.forEach(s => observer.observe(s));
				}
			} catch(e) {}
		});

		// Ripple keyframes
		const style = document.createElement('style');
		style.textContent = `@keyframes ripple { to { transform: scale(4); opacity: 0; } }`;
		document.head.appendChild(style);
	</script>
</body>
</html>
