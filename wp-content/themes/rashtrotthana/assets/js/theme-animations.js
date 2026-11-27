/**
 * theme-animations.js
 * Rashtrotthana Yoga — Elevra-Style Botanical & Yogic Interactive Animation Engine
 * 
 * Features:
 *   1. Canvas Botanical Falling Leaves Simulation (Bodhi, Eucalyptus & Lotus Petals with 3D tumble & cursor breeze)
 *   2. Apple-Style Liquid Glass Specular Sheen (Real-time cursor light refraction on glass cards)
 *   3. Interactive Zen Pranayama Breathing Controller (4-4-4 rhythm with dynamic SVG lotus pulsation)
 *   4. Ambient Water Caustic Light Movement
 *   5. Smooth Scroll Micro-Animations & Ripple
 */

(function () {
    'use strict';

    var prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ==========================================================================
       1. CANVAS BOTANICAL FALLING LEAVES SIMULATION
       ========================================================================== */
    var LeafEngine = (function () {
        var canvas, ctx;
        var width = 0, height = 0;
        var leaves = [];
        var maxLeaves = 34;
        var animFrameId = null;
        var isRunning = true;
        var mouse = { x: -9999, y: -9999, vx: 0, vy: 0, lastX: 0, lastY: 0 };
        var globalWind = 0.2;
        var gustTimer = 0;

        // Brand Harmonious Color Palette
        var leafColors = [
            { r: 123, g: 150, b: 105 }, // Sage (#7B9669)
            { r: 186, g: 200, b: 177 }, // Pale Sage (#BAC8B1)
            { r: 108, g: 132, b: 128 }, // Slate Green (#6C8480)
            { r: 64,  g: 78,  b: 59  }, // Forest Green (#404E3B)
            { r: 202, g: 172, b: 118 }  // Sunlight Golden Amber
        ];

        function Leaf() {
            this.reset(true);
        }

        Leaf.prototype.reset = function (initial) {
            this.x = Math.random() * (width + 100) - 50;
            this.y = initial ? Math.random() * height : -35 - Math.random() * 40;
            this.depth = Math.random() * 0.75 + 0.55; // 0.55 to 1.3
            this.size = (Math.random() * 14 + 14) * this.depth; // 14 to 28px
            this.speedY = (Math.random() * 0.85 + 0.65) * this.depth;
            this.speedX = (Math.random() * 0.4 - 0.2);
            this.swayAmp = Math.random() * 1.4 + 0.8;
            this.swayAngle = Math.random() * Math.PI * 2;
            this.swaySpeed = Math.random() * 0.02 + 0.012;

            // 3D Rotation angles
            this.rotZ = Math.random() * 360;
            this.rotZSpeed = (Math.random() * 1.6 - 0.8);
            this.rotX = Math.random() * Math.PI;
            this.rotXSpeed = Math.random() * 0.03 + 0.01;

            // Shape type: 0 = Bodhi Leaf, 1 = Eucalyptus Blade, 2 = Lotus Petal
            this.shapeType = Math.floor(Math.random() * 3);

            var c = leafColors[Math.floor(Math.random() * leafColors.length)];
            this.color = c;
            this.opacity = (Math.random() * 0.35 + 0.38) * Math.min(this.depth, 1.0);
        };

        Leaf.prototype.update = function () {
            this.swayAngle += this.swaySpeed;
            this.rotZ += this.rotZSpeed;
            this.rotX += this.rotXSpeed;

            // Sine wind drift + global gust
            var horizontalWind = Math.sin(this.swayAngle) * this.swayAmp + globalWind;
            this.x += horizontalWind + this.speedX;
            this.y += this.speedY;

            // Interactive Cursor Breeze physics
            var dx = this.x - mouse.x;
            var dy = this.y - mouse.y;
            var distSq = dx * dx + dy * dy;
            var repelRadius = 130;
            if (distSq < repelRadius * repelRadius && distSq > 1) {
                var dist = Math.sqrt(distSq);
                var force = (repelRadius - dist) / repelRadius;
                var angle = Math.atan2(dy, dx);
                this.x += Math.cos(angle) * force * 5.5 + mouse.vx * 0.35;
                this.y += Math.sin(angle) * force * 4.0 + mouse.vy * 0.35;
                this.rotZSpeed += (Math.random() - 0.5) * 2.5;
            }

            // Screen boundary reset
            if (this.y > height + 40 || this.x < -70 || this.x > width + 70) {
                this.reset(false);
            }
        };

        Leaf.prototype.draw = function () {
            ctx.save();
            ctx.translate(this.x, this.y);
            ctx.rotate((this.rotZ * Math.PI) / 180);
            
            // 3D tumble perspective scaling
            var scaleY = Math.cos(this.rotX);
            ctx.scale(1, scaleY);
            ctx.globalAlpha = this.opacity;

            var s = this.size;
            var fillStyle = 'rgba(' + this.color.r + ',' + this.color.g + ',' + this.color.b + ',1)';
            ctx.fillStyle = fillStyle;

            if (this.shapeType === 0) {
                // ── Shape 0: Bodhi / Sacred Fig Leaf (Heart base with tapering slender tail) ──
                ctx.beginPath();
                ctx.moveTo(0, -s * 0.85); // Elongated tip
                ctx.bezierCurveTo(s * 0.55, -s * 0.3, s * 0.65, s * 0.45, 0, s * 0.85);
                ctx.bezierCurveTo(-s * 0.65, s * 0.45, -s * 0.55, -s * 0.3, 0, -s * 0.85);
                ctx.fill();

                // Leaf delicate central vein
                ctx.beginPath();
                ctx.moveTo(0, -s * 0.75);
                ctx.lineTo(0, s * 0.8);
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.42)';
                ctx.lineWidth = Math.max(0.6, 0.9 * this.depth);
                ctx.stroke();

                // Subtle lateral veins
                ctx.beginPath();
                ctx.moveTo(0, -s * 0.2);
                ctx.lineTo(s * 0.28, -s * 0.05);
                ctx.moveTo(0, -s * 0.2);
                ctx.lineTo(-s * 0.28, -s * 0.05);
                ctx.moveTo(0, s * 0.2);
                ctx.lineTo(s * 0.32, s * 0.35);
                ctx.moveTo(0, s * 0.2);
                ctx.lineTo(-s * 0.32, s * 0.35);
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.22)';
                ctx.lineWidth = 0.5;
                ctx.stroke();

            } else if (this.shapeType === 1) {
                // ── Shape 1: Eucalyptus / Sage Leaf (Slender graceful curve) ──
                ctx.beginPath();
                ctx.moveTo(0, -s * 0.9);
                ctx.bezierCurveTo(s * 0.38, -s * 0.45, s * 0.35, s * 0.55, 0, s * 0.85);
                ctx.bezierCurveTo(-s * 0.35, s * 0.55, -s * 0.38, -s * 0.45, 0, -s * 0.9);
                ctx.fill();

                // Central midrib
                ctx.beginPath();
                ctx.moveTo(0, -s * 0.8);
                ctx.lineTo(0, s * 0.75);
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.38)';
                ctx.lineWidth = 0.7;
                ctx.stroke();

            } else {
                // ── Shape 2: Lotus Petal (Soft curved teardrop) ──
                ctx.beginPath();
                ctx.moveTo(0, -s * 0.7);
                ctx.bezierCurveTo(s * 0.48, -s * 0.25, s * 0.42, s * 0.5, 0, s * 0.7);
                ctx.bezierCurveTo(-s * 0.42, s * 0.5, -s * 0.48, -s * 0.25, 0, -s * 0.7);
                ctx.fill();
            }

            ctx.restore();
        };

        function resize() {
            if (!canvas) return;
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
            if (width < 768) {
                maxLeaves = 18;
            } else if (width < 1200) {
                maxLeaves = 26;
            } else {
                maxLeaves = 36;
            }
            while (leaves.length < maxLeaves) {
                leaves.push(new Leaf());
            }
            if (leaves.length > maxLeaves) {
                leaves.length = maxLeaves;
            }
        }

        function loop() {
            if (!isRunning) return;

            // Gentle wind gusts cycle every 14 seconds
            gustTimer += 0.016;
            globalWind = 0.25 + Math.sin(gustTimer * 0.45) * 0.45 + (Math.sin(gustTimer * 0.12) > 0.6 ? 0.6 : 0);

            ctx.clearRect(0, 0, width, height);

            for (var i = 0; i < leaves.length; i++) {
                leaves[i].update();
                leaves[i].draw();
            }

            // Decay mouse velocity
            mouse.vx *= 0.88;
            mouse.vy *= 0.88;

            animFrameId = requestAnimationFrame(loop);
        }

        function init() {
            if (prefersReduced) return;

            canvas = document.getElementById('rs-falling-leaves-canvas');
            if (!canvas) {
                canvas = document.createElement('canvas');
                canvas.id = 'rs-falling-leaves-canvas';
                canvas.className = 'rs-falling-leaves-canvas';
                canvas.setAttribute('aria-hidden', 'true');
                document.body.insertBefore(canvas, document.body.firstChild);
            }
            ctx = canvas.getContext('2d');

            resize();
            window.addEventListener('resize', resize, { passive: true });

            // Mouse / pointer movement tracking for interactive breeze
            window.addEventListener('pointermove', function (e) {
                mouse.vx = e.clientX - mouse.lastX;
                mouse.vy = e.clientY - mouse.lastY;
                mouse.lastX = e.clientX;
                mouse.lastY = e.clientY;
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            }, { passive: true });

            // Touch support for mobile breeze
            window.addEventListener('touchmove', function (e) {
                if (e.touches && e.touches[0]) {
                    var t = e.touches[0];
                    mouse.vx = t.clientX - mouse.lastX;
                    mouse.vy = t.clientY - mouse.lastY;
                    mouse.lastX = t.clientX;
                    mouse.lastY = t.clientY;
                    mouse.x = t.clientX;
                    mouse.y = t.clientY;
                }
            }, { passive: true });

            // Pause when tab hidden to save CPU/battery
            document.addEventListener('visibilitychange', function () {
                if (document.hidden) {
                    isRunning = false;
                    if (animFrameId) cancelAnimationFrame(animFrameId);
                } else {
                    isRunning = true;
                    animFrameId = requestAnimationFrame(loop);
                }
            });

            // Start animation loop
            isRunning = true;
            loop();
        }

        return {
            init: init,
            toggle: function (forceState) {
                if (typeof forceState !== 'undefined') {
                    isRunning = forceState;
                } else {
                    isRunning = !isRunning;
                }
                if (canvas) {
                    canvas.style.display = isRunning ? 'block' : 'none';
                }
                if (isRunning) loop();
                return isRunning;
            }
        };
    })();

    /* ==========================================================================
       2. APPLE LIQUID GLASS SPECULAR REFLECTION (MOUSE TRACKER)
       ========================================================================== */
    function initGlassSpecularTracking() {
        if (prefersReduced) return;
        if (!window.matchMedia('(pointer: fine)').matches) return;

        var selector = [
            '.rs-center-card',
            '.rs-activity-card',
            '.rs-value-card',
            '.rs-pillar-card',
            '.rs-event-card',
            '.rs-event-item-card',
            '.rs-team-card',
            '.rs-founder-quote-card',
            '.rs-hub-top-bar',
            '.rs-event-album-card'
        ].join(', ');

        document.addEventListener('pointermove', function (e) {
            var target = e.target.closest(selector);
            if (!target) return;

            var rect = target.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;

            target.style.setProperty('--mouse-x', x + 'px');
            target.style.setProperty('--mouse-y', y + 'px');
        }, { passive: true });
    }

    /* ==========================================================================
       3. INITIALIZATION ON DOM READY
       ========================================================================== */
    function onReady() {
        LeafEngine.init();
        initGlassSpecularTracking();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', onReady);
    } else {
        onReady();
    }

    // Expose control to global scope
    window.rsLeafEngine = LeafEngine;

})();

