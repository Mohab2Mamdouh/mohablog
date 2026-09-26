{{--
    Floating "View as Markdown" button.

    Self-contained: every rule is namespaced under .md-view-btn and every value
    is literal, so the partial can be dropped into any template without
    inheriting or leaking styles. Pinned bottom-left to stay clear of the
    top-right controls the templates already use.
--}}
<style>
    .md-view-btn {
        position: fixed;
        left: 24px;
        bottom: 24px;
        z-index: 200;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 44px;
        padding: 0 18px;
        border-radius: 22px;
        background: #161b22;
        border: 1px solid #30363d;
        color: #e6edf3;
        font-family: ui-monospace, SFMono-Regular, 'SF Mono', Menlo, Consolas, monospace;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.28);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .md-view-btn:hover,
    .md-view-btn:focus-visible {
        transform: translateY(-2px);
        border-color: #ff2d20;
        color: #ffffff;
        box-shadow: 0 8px 22px rgba(255, 45, 32, 0.3);
        text-decoration: none;
    }
    .md-view-btn .md-view-btn__mark {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 26px;
        height: 18px;
        padding: 0 5px;
        border-radius: 3px;
        background: #ff2d20;
        color: #ffffff;
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.06em;
    }
    @media (max-width: 600px) {
        .md-view-btn {
            left: 16px;
            bottom: 16px;
            height: 40px;
            padding: 0 14px;
            font-size: 0.75rem;
        }
        .md-view-btn .md-view-btn__label { display: none; }
    }
    @media print {
        .md-view-btn { display: none; }
    }
</style>

<a href="{{ route('cv.markdown.preview') }}"
   class="md-view-btn"
   title="See the Markdown version of this CV that AI agents receive">
    <span class="md-view-btn__mark">MD</span>
    <span class="md-view-btn__label">View as Markdown</span>
</a>
