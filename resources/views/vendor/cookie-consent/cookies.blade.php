<aside id="cookies-policy" class="cookies cookies--no-js" data-text="{{ json_encode(__('cookieConsent::cookies.details')) }}">
    <div class="cookies__alert">
        <div class="cookies__container">
            <div class="cookies__wrapper">
                <h2 class="cookies__title">@lang('cookieConsent::cookies.title')</h2>
                <div class="cookies__intro">
                    <p>@lang('cookieConsent::cookies.intro')</p>
                    @if($policy)
                        <p>@lang('cookieConsent::cookies.link', ['url' => $policy])</p>
                    @endif
                </div>
                <div class="cookies__actions">
                    @cookieconsentbutton(action: 'accept.essentials', label: __('cookieConsent::cookies.essentials'), attributes: ['class' => 'cookiesBtn cookiesBtn--essentials'])
                    @cookieconsentbutton(action: 'accept.all', label: __('cookieConsent::cookies.all'), attributes: ['class' => 'cookiesBtn cookiesBtn--accept'])
                </div>
            </div>
        </div>
            <a href="#cookies-policy-customize" class="cookies__btn cookies__btn--customize">
                <span>@lang('cookieConsent::cookies.customize')</span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M14.7559 11.9782C15.0814 11.6527 15.0814 11.1251 14.7559 10.7996L10.5893 6.63297C10.433 6.47669 10.221 6.3889 10 6.38889C9.77899 6.38889 9.56703 6.47669 9.41075 6.63297L5.24408 10.7996C4.91864 11.1251 4.91864 11.6527 5.24408 11.9782C5.56951 12.3036 6.09715 12.3036 6.42259 11.9782L10 8.40074L13.5774 11.9782C13.9028 12.3036 14.4305 12.3036 14.7559 11.9782Z" fill="#2C2E30"/>
                </svg>
            </a>
        <div class="cookies__expandable cookies__expandable--custom" id="cookies-policy-customize">
            <form action="{{ route('cookieconsent.accept.configuration') }}" method="post" class="cookies__customize">
                @csrf
                <div class="cookies__sections">
                    @foreach($cookies->getCategories() as $category)
                    <div class="cookies__section">
                        <label for="cookies-policy-check-{{ $category->key() }}" class="cookies__category">
                            @if ($category->key() === 'essentials')
                                <input type="hidden" name="categories[]" value="{{ $category->key() }}" />
                                <input type="checkbox" name="categories[]" value="{{ $category->key() }}" id="cookies-policy-check-{{ $category->key() }}" checked="checked" disabled="disabled" />
                            @else
                                <input type="checkbox" name="categories[]" value="{{ $category->key() }}" id="cookies-policy-check-{{ $category->key() }}" />
                            @endif
                            <span class="cookies__box">
                                <strong class="cookies__label">{{ $category->title }}</strong>
                            </span>
                            @if($category->description)
                                <p class="cookies__info">{{ $category->description }}</p>
                            @endif
                        </label>

                        <div class="cookies__expandable" id="cookies-policy-{{ $category->key() }}">
                            <ul class="cookies__definitions">
                                @foreach($category->getCookies() as $cookie)
                                <li class="cookies__cookie">
                                    <p class="cookies__name">{{ $cookie->name }}</p>
                                    <p class="cookies__duration">{{ \Carbon\CarbonInterval::minutes($cookie->duration)->cascade() }}</p>
                                    @if($cookie->description)
                                        <p class="cookies__description">{{ $cookie->description }}</p>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <a href="#cookies-policy-{{ $category->key() }}" class="cookies__details">@lang('cookieConsent::cookies.details.more')</a>
                    </div>
                    @endforeach
                </div>
                <div class="cookies__save">
                    <button type="submit" class="cookiesBtn__link">@lang('cookieConsent::cookies.save')</button>
                </div>
            </form>
        </div>
    </div>
</aside>

{{-- STYLES & SCRIPT : feel free to remove them and add your own --}}

<script data-cookie-consent>
    {!! file_get_contents(LCC_ROOT . '/dist/script.js') !!}
</script>
<style data-cookie-consent>
#cookies-policy.cookies{bottom:0;font-size:16px;max-height:100%;max-width:100%;overflow:auto;position:fixed;right:0;transition:transform .2s ease-out,opacity .2s ease-out;z-index:9999}#cookies-policy.cookies--closing{opacity:0;transform:translateY(10px)}#cookies-policy.cookies--show .cookies__btn--customize{border-bottom:1px solid #e7e8e9;border-top:none}#cookies-policy.cookies--show .cookies__btn svg{transform:rotate(180deg)}#cookies-policy.cookies--no-js .cookies__expandable:target,#cookies-policy.cookies--no-js .cookies__section .cookies__expandable{height:auto;opacity:1;transition:height .3s ease-out,opacity .3s ease-out;visibility:visible}#cookies-policy.cookies--no-js .cookies__details{display:none}#cookies-policy.cookies--no-js .cookies__sections{max-height:-moz-fit-content;max-height:fit-content}#cookies-policy.cookies--no-js svg{display:none}#cookies-policy .cookies__expandable{display:block;height:0;opacity:0;overflow:hidden;transition:height .3s ease-out,opacity .3s ease-out,visibility 0s linear .3s;visibility:hidden}#cookies-policy .cookies__expandable--open{height:auto;opacity:1;transition:height .3s ease-out,opacity .3s ease-out;visibility:visible}#cookies-policy .cookies__alert{background:#fff;border:1px solid #e7e8e9;border-radius:8px;box-shadow:0 12px 12px -8px rgba(0,0,0,.08),0 0 4px rgba(0,0,0,.04);margin:4%;max-height:90%;max-width:90%;width:22em}#cookies-policy .cookies__container{display:block;height:auto;opacity:1;overflow:hidden;transition:height .3s ease-out,opacity .3s ease-out,visibility 0s linear .1s;visibility:visible}#cookies-policy .cookies__container--hide{height:0;opacity:0;transition:height .3s ease-out,opacity .3s ease-out,visibility 0s linear .3s;visibility:hidden}#cookies-policy .cookies__wrapper{padding:1em 1.5em}#cookies-policy .cookies__title{color:#2c2e30;font-weight:700;line-height:1.4em;margin-bottom:.8em}#cookies-policy .cookies__intro{color:#2c2e30;font-size:.875em;font-weight:450;line-height:1.4em}#cookies-policy .cookies__intro p{margin-top:1em}#cookies-policy .cookies__intro p:first-child{margin-top:0}#cookies-policy .cookies__intro a{color:inherit;text-decoration:underline;transition:color .2s ease-out}#cookies-policy .cookies__intro a:focus,#cookies-policy .cookies__intro a:hover{color:#EE5C14}#cookies-policy .cookies__actions{display:flex;flex-direction:column;gap:4px;justify-content:space-between;margin-top:1em}#cookies-policy .cookies__btn--customize{align-items:center;border-top:1px solid #e7e8e9;color:#2c2e30;display:flex;font-size:.875em;font-weight:600;justify-content:space-between;line-height:1em;padding:1.125em 24px;position:relative;text-decoration:none}#cookies-policy .cookies__btn svg{transition:transform .2s ease-out}#cookies-policy .cookies__sections{max-height:450px;overflow-y:scroll}#cookies-policy .cookies__section{padding:0 1.5em}#cookies-policy .cookies__section+.cookies__section{border-top:1px solid #eee}#cookies-policy .cookies__box,#cookies-policy .cookies__category{display:block;overflow:hidden;position:relative}#cookies-policy .cookies__category input{display:block;margin:0;padding:0;position:absolute;right:105%;top:0}#cookies-policy .cookies__box{cursor:pointer;line-height:1.4em;padding:1em 3em 1em 0}#cookies-policy .cookies__box:after,#cookies-policy .cookies__box:before{border-radius:1.4em;content:"";display:block;position:absolute;top:50%}#cookies-policy .cookies__box:after{background:#e7e8e9;height:1.4em;margin-top:-.7em;right:0;transition:background .2s ease-out,opacity .2s ease-out;width:2.5em;z-index:0}#cookies-policy .cookies__box:before{background:#fff;height:1em;margin-top:-.5em;right:.75em;transform:translateX(-.55em);transition:transform .2s ease-out;width:1em;z-index:1}#cookies-policy .cookies__category input:checked+.cookies__box:after{background:#EE5C14;opacity:1}#cookies-policy .cookies__category input:disabled+.cookies__box:after{opacity:.6}#cookies-policy .cookies__category input:checked+.cookies__box:before{transform:translateX(.55em)}#cookies-policy .cookies__label{color:#2c2e30;font-size:.875em;font-weight:600}#cookies-policy .cookies__info{color:#2c2e30;font-size:.875em;font-weight:450;line-height:1.4em}#cookies-policy .cookies__details{color:#EE5C14;display:block;font-size:.875em;margin:.625em 0 .9em;transition:color .2s ease-out}#cookies-policy .cookies__details:focus,#cookies-policy .cookies__details:hover{color:#EE5C14}#cookies-policy .cookies__definitions{color:#676767;font-size:.875em;line-height:1.2em;padding-top:.8em}#cookies-policy .cookies__cookie+.cookies__cookie{margin-top:1em}#cookies-policy .cookies__name{color:#8a8e92;display:inline;font-weight:600;line-height:22px}#cookies-policy .cookies__duration{color:#8a8e92;display:inline;text-align:right}#cookies-policy .cookies__description{color:#8a8e92;display:block;line-height:120%;padding-top:.3em;text-align:left;width:100%}#cookies-policy .cookies__save{border-top:1px solid #e7e8e9;display:flex;justify-content:flex-end;margin-top:.4em;padding:.75em 1.5em}#cookies-policy .cookiesBtn{width:100%}#cookies-policy .cookiesBtn__link{background:#EE5C14;border:1px solid #EE5C14;border-radius:4px;color:#fff;cursor:pointer;display:block;font:inherit;font-size:14px;font-weight:600;line-height:1em;margin:0;overflow:hidden;padding:.86em 1em;text-align:center;text-decoration:none;text-overflow:ellipsis;transition:opacity .2s ease-out;white-space:nowrap;width:100%}#cookies-policy .cookiesBtn__link:focus,#cookies-policy .cookiesBtn__link:hover{opacity:.8}
</style>