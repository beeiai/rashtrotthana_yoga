<?php
/**
 * Interactive Yoga Flow Animation — Rashtrotthana Hero Section
 * Displays a serene yogi transitioning gracefully through classical asanas.
 */
?>
<div class="rs-hero-yoga-flow" id="rs-hero-yoga-flow" role="region" aria-label="Yoga Asana Flow Animation">
    <div class="rs-yoga-flow-card">
        <!-- Floating Ambient Aura Rings -->
        <div class="rs-yoga-aura-ring rs-yoga-aura-outer" aria-hidden="true"></div>
        <div class="rs-yoga-aura-ring rs-yoga-aura-inner" aria-hidden="true"></div>

        <!-- Dynamic Yoga SVG Figures Container -->
        <div class="rs-yoga-stage">
            <!-- 1. Padmasana (Lotus Meditation) -->
            <svg class="rs-yoga-pose is-active" id="pose-padmasana" viewBox="0 0 200 210" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Seated Pedestal Ripple -->
                <ellipse cx="100" cy="186" rx="65" ry="12" fill="rgba(123, 150, 105, 0.14)" />
                <ellipse cx="100" cy="186" rx="45" ry="8" stroke="rgba(123, 150, 105, 0.35)" stroke-width="1.2" stroke-dasharray="3 3" />
                
                <!-- Yogi Silhouette: Padmasana -->
                <g class="rs-yogi-figure">
                    <!-- Head & Topknot -->
                    <circle cx="100" cy="52" r="14" fill="#1E281B" />
                    <circle cx="100" cy="35" r="5" fill="#404E3B" />
                    <!-- Neck -->
                    <path d="M96 66 L104 66 L105 74 L95 74 Z" fill="#1E281B" />
                    <!-- Torso & Shoulders -->
                    <path d="M80 78 C80 74 88 72 100 72 C112 72 120 74 120 78 C122 96 118 122 114 140 L86 140 C82 122 78 96 80 78 Z" fill="#1E281B" />
                    <!-- Arms in Chin Mudra resting on knees -->
                    <path d="M80 78 C70 94 62 118 56 142 C54 150 62 156 70 152 C78 148 84 136 86 128" stroke="#1E281B" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M120 78 C130 94 138 118 144 142 C146 150 138 156 130 152 C122 148 116 136 114 128" stroke="#1E281B" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" />
                    <!-- Folded Cross Legs / Lotus -->
                    <path d="M52 156 C44 165 42 178 58 184 C76 190 100 186 100 186 C100 186 124 190 142 184 C158 178 156 165 148 156 C138 146 122 148 100 150 C78 148 62 146 52 156 Z" fill="#243221" />
                    <!-- Hands resting with fingers -->
                    <circle cx="56" cy="144" r="5" fill="#404E3B" />
                    <circle cx="144" cy="144" r="5" fill="#404E3B" />
                    <!-- Heart Chakra (Anahata) Glowing Node -->
                    <circle class="rs-chakra-pulse" cx="100" cy="98" r="4.5" fill="#7B9669" />
                </g>
            </svg>

            <!-- 2. Vrikshasana (Tree of Balance) -->
            <svg class="rs-yoga-pose" id="pose-vrikshasana" viewBox="0 0 200 210" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Ground Balance Disc -->
                <ellipse cx="100" cy="188" rx="48" ry="10" fill="rgba(123, 150, 105, 0.14)" />
                <ellipse cx="100" cy="188" rx="32" ry="6" stroke="rgba(123, 150, 105, 0.35)" stroke-width="1.2" stroke-dasharray="3 3" />

                <!-- Yogi Silhouette: Vrikshasana -->
                <g class="rs-yogi-figure">
                    <!-- Joined Anjali Hands Overhead -->
                    <path d="M96 22 C96 16 100 12 100 12 C100 12 104 16 104 22 L100 26 Z" fill="#7B9669" />
                    <!-- Arched Arms Reaching Up -->
                    <path d="M100 24 C90 32 82 46 82 62" stroke="#1E281B" stroke-width="6.5" stroke-linecap="round" />
                    <path d="M100 24 C110 32 118 46 118 62" stroke="#1E281B" stroke-width="6.5" stroke-linecap="round" />
                    <!-- Head & Neck -->
                    <circle cx="100" cy="45" r="13" fill="#1E281B" />
                    <path d="M96 58 L104 58 L104 66 L96 66 Z" fill="#1E281B" />
                    <!-- Torso -->
                    <path d="M82 64 C82 60 90 58 100 58 C110 58 118 60 118 64 C120 84 116 108 112 126 L88 126 C84 108 80 84 82 64 Z" fill="#1E281B" />
                    <!-- Grounded Standing Left Leg -->
                    <path d="M94 126 L94 186 C94 188 100 190 106 188 L106 126 Z" fill="#243221" />
                    <!-- Bent Right Leg (Foot against inner knee) -->
                    <path d="M108 126 C118 135 132 144 136 150 C138 154 134 158 126 156 L98 142" stroke="#1E281B" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" />
                    <!-- Heart Chakra Node -->
                    <circle class="rs-chakra-pulse" cx="100" cy="85" r="4.5" fill="#7B9669" />
                </g>
            </svg>

            <!-- 3. Virabhadrasana (Warrior of Strength) -->
            <svg class="rs-yoga-pose" id="pose-virabhadrasana" viewBox="0 0 200 210" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Ground Footing -->
                <ellipse cx="100" cy="188" rx="68" ry="10" fill="rgba(123, 150, 105, 0.14)" />

                <!-- Yogi Silhouette: Virabhadrasana II -->
                <g class="rs-yogi-figure">
                    <!-- Head (Turned Gazing Right) -->
                    <circle cx="112" cy="54" r="13" fill="#1E281B" />
                    <!-- Horizontally Outstretched Arms -->
                    <path d="M38 78 L98 78" stroke="#1E281B" stroke-width="6.5" stroke-linecap="round" />
                    <path d="M106 78 L168 78" stroke="#1E281B" stroke-width="6.5" stroke-linecap="round" />
                    <!-- Torso -->
                    <path d="M96 74 C96 68 102 66 108 66 C114 66 118 68 118 74 C118 92 116 112 112 126 L96 126 C94 112 94 92 96 74 Z" fill="#1E281B" />
                    <!-- Back Extended Left Leg -->
                    <path d="M96 124 L52 182 C50 185 56 188 62 186 L102 128 Z" fill="#243221" />
                    <!-- Front Bent Right Leg (Lunge) -->
                    <path d="M110 124 C122 128 138 132 144 142 L144 186 C144 188 150 188 152 186 L152 140 C146 130 132 125 116 122 Z" fill="#1E281B" />
                    <!-- Heart Chakra Node -->
                    <circle class="rs-chakra-pulse" cx="107" cy="88" r="4.5" fill="#7B9669" />
                </g>
            </svg>

            <!-- 4. Natarajasana (Lord of the Dance) -->
            <svg class="rs-yoga-pose" id="pose-natarajasana" viewBox="0 0 200 210" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Grounding Base -->
                <ellipse cx="100" cy="188" rx="55" ry="10" fill="rgba(123, 150, 105, 0.14)" />

                <!-- Yogi Silhouette: Natarajasana -->
                <g class="rs-yogi-figure">
                    <!-- Head & Neck -->
                    <circle cx="112" cy="52" r="13" fill="#1E281B" />
                    <!-- Front Forward Reaching Arm (Mudraware) -->
                    <path d="M106 74 C122 66 142 56 162 48" stroke="#1E281B" stroke-width="6" stroke-linecap="round" />
                    <circle cx="164" cy="47" r="4" fill="#7B9669" />
                    <!-- Torso with Graceful Forward Arch -->
                    <path d="M96 72 C100 66 112 66 116 72 C118 90 114 110 108 126 L92 124 C90 108 92 88 96 72 Z" fill="#1E281B" />
                    <!-- Back Leg Arching High Behind -->
                    <path d="M96 124 C82 118 64 104 56 86 C50 72 58 58 70 54" stroke="#243221" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" />
                    <!-- Back Arm Holding Arched Foot -->
                    <path d="M96 76 C84 68 76 60 70 54" stroke="#1E281B" stroke-width="6" stroke-linecap="round" />
                    <!-- Grounded Straight Leg -->
                    <path d="M102 126 L102 186 C102 188 108 189 112 187 L110 126 Z" fill="#1E281B" />
                    <!-- Heart Chakra Node -->
                    <circle class="rs-chakra-pulse" cx="106" cy="86" r="4.5" fill="#7B9669" />
                </g>
            </svg>

            <!-- 5. Trikonasana (Triangle of Expansion) -->
            <svg class="rs-yoga-pose" id="pose-trikonasana" viewBox="0 0 200 210" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Grounding Line -->
                <ellipse cx="100" cy="188" rx="66" ry="10" fill="rgba(123, 150, 105, 0.14)" />

                <!-- Yogi Silhouette: Trikonasana -->
                <g class="rs-yogi-figure">
                    <!-- Skyward Raised Arm -->
                    <path d="M106 82 L90 28" stroke="#1E281B" stroke-width="6" stroke-linecap="round" />
                    <circle cx="89" cy="26" r="4" fill="#7B9669" />
                    <!-- Earth Reaching Downward Arm -->
                    <path d="M106 82 L138 152" stroke="#1E281B" stroke-width="6" stroke-linecap="round" />
                    <!-- Head Gazing Skyward -->
                    <circle cx="102" cy="62" r="13" fill="#1E281B" />
                    <!-- Torso in Triangle Lateral Extension -->
                    <path d="M96 74 C100 68 112 70 116 78 L114 126 L94 120 Z" fill="#1E281B" />
                    <!-- Wide Stance Legs (Triangle Formation) -->
                    <path d="M96 120 L58 184 C56 187 62 189 68 186 L102 124 Z" fill="#243221" />
                    <path d="M112 124 L146 184 C148 187 154 187 156 184 L116 122 Z" fill="#1E281B" />
                    <!-- Heart Chakra Node -->
                    <circle class="rs-chakra-pulse" cx="106" cy="88" r="4.5" fill="#7B9669" />
                </g>
            </svg>
        </div>

        <!-- Floating Yogic Caption Pill -->
        <div class="rs-yoga-caption-wrap">
            <span class="rs-yoga-badge-step" id="rs-yoga-step">1/5</span>
            <div class="rs-yoga-info-text">
                <strong class="rs-yoga-pose-name" id="rs-yoga-name">Padmasana</strong>
                <span class="rs-yoga-pose-desc" id="rs-yoga-desc">Meditative Serenity &amp; Stillness</span>
            </div>
        </div>

        <!-- Interactive Pose Selector Dots -->
        <div class="rs-yoga-dots" aria-label="Yoga pose switcher">
            <button type="button" class="rs-yoga-dot is-active" data-index="0" aria-label="Padmasana"></button>
            <button type="button" class="rs-yoga-dot" data-index="1" aria-label="Vrikshasana"></button>
            <button type="button" class="rs-yoga-dot" data-index="2" aria-label="Virabhadrasana"></button>
            <button type="button" class="rs-yoga-dot" data-index="3" aria-label="Natarajasana"></button>
            <button type="button" class="rs-yoga-dot" data-index="4" aria-label="Trikonasana"></button>
        </div>
    </div>
</div>
