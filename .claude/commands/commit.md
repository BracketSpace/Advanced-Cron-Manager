---
description: Analyze uncommitted changes and create intelligent commits following Conventional Commits standard
argument-hint: [clickup-task-id] (optional)
allowed-tools: Bash(git *), Read, Glob, Grep
---

I'll analyze your uncommitted changes and automatically determine the appropriate commit type and description, potentially breaking changes into multiple granular commits if needed.

First, let me examine all uncommitted changes:

```bash
echo "=== Git Status ==="
git status --porcelain

echo -e "\n=== Staged Changes ==="
git diff --cached --stat
if [ $(git diff --cached --name-only | wc -l) -gt 0 ]; then
    echo -e "\nDetailed staged changes:"
    git diff --cached
fi

echo -e "\n=== Unstaged Changes ==="
git diff --stat
if [ $(git diff --name-only | wc -l) -gt 0 ]; then
    echo -e "\nDetailed unstaged changes:"
    git diff
fi

echo -e "\n=== Untracked Files ==="
git ls-files --others --exclude-standard
```

Now I'll analyze these changes to determine:

1. **File types and patterns** - What kinds of files are being modified
2. **Change scope** - Whether changes should be grouped or separated
3. **Commit types** - Following Conventional Commits (feat, fix, chore, docs, style, refactor, test, etc.)
4. **Appropriate descriptions** - Based on the actual changes made

Based on my analysis, I'll propose one or more commits with:
- Appropriate conventional commit types
- Clear, descriptive commit messages
- Logical grouping of related changes
- Optional ClickUp task ID integration (if provided as $1)
- **No Claude copyrights or AI attribution** - commits should be clean and professional

Let me analyze the changes and propose the commit structure. I'll ask for your approval before making any commits.

**Analysis Results:**

The changes will be categorized and I'll suggest commits like:
- `feat: add new functionality for X`
- `fix: resolve issue with Y`  
- `chore: update dependencies/configuration`
- `docs: update documentation`
- `style: formatting and code style improvements`
- `refactor: restructure code without changing functionality`

Each proposed commit will include:
- **Type**: Determined from change analysis
- **Description**: Generated from actual changes
- **Files included**: Specific files for each commit
- **ClickUp task ID**: Added if provided ($1)

Would you like me to proceed with creating the proposed commits?