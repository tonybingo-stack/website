import "momentum-trail"

declare module "momentum-trail" {
    export interface RouterGlobal {"url":"http:\/\/localhost:8000","port":8000,"defaults":[],"routes":{"login":{"uri":"login","methods":["GET","HEAD"]},"login.store":{"uri":"login","methods":["POST"]},"logout":{"uri":"logout","methods":["POST"]},"password.request":{"uri":"forgot-password","methods":["GET","HEAD"]},"password.reset":{"uri":"reset-password\/{token}","methods":["GET","HEAD"],"parameters":["token"]},"password.email":{"uri":"forgot-password","methods":["POST"]},"password.update":{"uri":"reset-password","methods":["POST"]},"register":{"uri":"register","methods":["GET","HEAD"]},"verification.notice":{"uri":"email\/verify","methods":["GET","HEAD"]},"verification.verify":{"uri":"email\/verify\/{id}\/{hash}","methods":["GET","HEAD"],"parameters":["id","hash"]},"verification.send":{"uri":"email\/verification-notification","methods":["POST"]},"user-profile-information.update":{"uri":"user\/profile-information","methods":["PUT"]},"user-password.update":{"uri":"user\/password","methods":["PUT"]},"password.confirmation":{"uri":"user\/confirmed-password-status","methods":["GET","HEAD"]},"password.confirm":{"uri":"user\/confirm-password","methods":["POST"]},"two-factor.login":{"uri":"two-factor-challenge","methods":["GET","HEAD"]},"two-factor.enable":{"uri":"user\/two-factor-authentication","methods":["POST"]},"two-factor.confirm":{"uri":"user\/confirmed-two-factor-authentication","methods":["POST"]},"two-factor.disable":{"uri":"user\/two-factor-authentication","methods":["DELETE"]},"two-factor.qr-code":{"uri":"user\/two-factor-qr-code","methods":["GET","HEAD"]},"two-factor.secret-key":{"uri":"user\/two-factor-secret-key","methods":["GET","HEAD"]},"two-factor.recovery-codes":{"uri":"user\/two-factor-recovery-codes","methods":["GET","HEAD"]},"profile.show":{"uri":"user\/profile","methods":["GET","HEAD"]},"other-browser-sessions.destroy":{"uri":"user\/other-browser-sessions","methods":["DELETE"]},"current-user-photo.destroy":{"uri":"user\/profile-photo","methods":["DELETE"]},"current-user.destroy":{"uri":"user","methods":["DELETE"]},"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"cookieconsent.script":{"uri":"cookie-consent\/script","methods":["GET","HEAD"]},"cookieconsent.accept.all":{"uri":"cookie-consent\/accept-all","methods":["POST"]},"cookieconsent.accept.essentials":{"uri":"cookie-consent\/accept-essentials","methods":["POST"]},"cookieconsent.accept.configuration":{"uri":"cookie-consent\/configure","methods":["POST"]},"cookieconsent.reset":{"uri":"cookie-consent\/reset","methods":["POST"]},"dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"login.destroy":{"uri":"login\/{login}","methods":["DELETE"],"parameters":["login"]},"login.create":{"uri":"login\/create","methods":["GET","HEAD"]},"welcome":{"uri":"\/","methods":["GET","HEAD"]},"projects.show":{"uri":"projects\/{project}","methods":["GET","HEAD"],"parameters":["project"]},"send-email":{"uri":"send-email","methods":["POST"]},"terms.show":{"uri":"terms","methods":["GET","HEAD"]},"policy.show":{"uri":"policy","methods":["GET","HEAD"]},"cookie.show":{"uri":"cookie","methods":["GET","HEAD"]}},"wildcards":{"login.*":[],"password.*":[],"verification.*":[],"user-profile-information.*":[],"user-password.*":[],"two-factor.*":[],"profile.*":[],"other-browser-sessions.*":[],"current-user-photo.*":[],"current-user.*":[],"sanctum.*":[],"cookieconsent.*":[],"cookieconsent.accept.*":[],"projects.*":[],"terms.*":[],"policy.*":[],"cookie.*":[]}}
}