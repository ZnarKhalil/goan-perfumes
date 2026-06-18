/**
 * Fixed, full-bleed backdrop that gives the page depth instead of flat color:
 * a deep obsidian base, two slow drifting warm "aurora" glows and a fine film
 * grain. Sits behind every section (z-0) so content can layer over it.
 */
export default function Atmosphere() {
    return (
        <div
            aria-hidden
            className="pointer-events-none fixed inset-0 -z-10 overflow-hidden bg-[#0b0907]"
        >
            <div className="absolute inset-0 bg-[radial-gradient(120%_120%_at_50%_0%,#1a1209_0%,#0b0907_55%,#070504_100%)]" />

            <div className="vitrine-aurora absolute -top-1/4 left-[-10%] h-[70vh] w-[70vh] rounded-full bg-[radial-gradient(circle,rgba(231,200,137,0.20),transparent_62%)] blur-3xl" />
            <div
                className="vitrine-aurora absolute right-[-12%] bottom-[-18%] h-[64vh] w-[64vh] rounded-full bg-[radial-gradient(circle,rgba(173,108,58,0.18),transparent_60%)] blur-3xl"
                style={{ animationDelay: '-13s', animationDuration: '32s' }}
            />

            <div className="absolute inset-0 grain-layer opacity-[0.12] mix-blend-overlay" />

            <div className="absolute inset-x-0 top-0 h-px bg-linear-to-r from-transparent via-[#e7c889]/30 to-transparent" />
        </div>
    );
}
