# How deploying works

## The short version

```bash
git add -A
git commit -m "what you changed"
git push
```

That's it. `git push` sends the code to GitHub **and** deploys it to the live
server. You don't run anything else.

The push takes about two minutes (InMotion opcache wait). Watch the output:
it tells you exactly what happened.

## What happens when you push

1. **Syntax gate (`pre-receive`).** Every `.php` file in the commit is parsed
   with `php -l` on the server. If any file has a syntax error the push is
   **rejected** and the live site is never touched. You'll see which file.
2. **Checkout.** The new code is written into the live docroot.
3. **Opcache wait (95s).** InMotion re-checks compiled PHP every 90s; the hook
   waits it out before checking health.
4. **Health check.** The server fetches `https://gracepariser.co.uk/` and
   expects HTTP 200. It retries up to 6 times, 5 seconds apart.
5. **Auto-rollback.** If the health check fails, the previous known-good commit
   is checked out again and re-verified, and the push reports failure.

The last commit that passed its health check is recorded in `deployed-sha`
inside the bare repo, and that's what a rollback returns to.

## Rolling back by hand

```bash
git revert HEAD
git push
```

## The one rule

**Don't edit files directly on the live server.** The repo is the source of
truth; a direct edit will be silently overwritten by the next deploy.

## What is deliberately NOT in git

`config.php`, `uploads/`, `logs/`. They stay on the server and deploys never
touch them.

## Where things live

| | |
|---|---|
| Host | InMotion |
| SSH | `nfc6da5@209.182.203.135:2222` |
| Docroot | `/home/nfc6da5/gracepariser.co.uk` |
| Bare repo | `/home/nfc6da5/git/gracepariser.co.uk.git` |

The bare repo sits **outside** the web root on purpose, so no `.git` folder is
ever reachable over the web.

## Changing the hooks

The hooks live in this repo under `deploy/`. Editing them here does **not**
update the server. Copy them up and strip Windows line endings:

```bash
scp -P 2222 deploy/post-receive nfc6da5@209.182.203.135:/home/nfc6da5/
ssh -p 2222 nfc6da5@209.182.203.135 \
  "sed 's/\r$//' /home/nfc6da5/post-receive > /home/nfc6da5/git/gracepariser.co.uk.git/hooks/post-receive && \
   chmod 755 /home/nfc6da5/git/gracepariser.co.uk.git/hooks/post-receive"
```

Per-site settings (docroot, health URL, wait time) are in `deploy.conf` next to
the bare repo, so the hook script itself is identical to the other sites.
