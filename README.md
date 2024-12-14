# SyncSystem - WP Platform
Boiler plate for headless WordPress platform.

### Versioning and Commits Guidelines

**Semantic Versioning**:

We follow the [Semantic Versioning 2.0.0](https://semver.org/) guidelines for versioning our project. Here's how we manage version numbers:

- **MAJOR** version (X) is incremented when you make incompatible API changes:
  - Example: `v2.0.0`
- **MINOR** version (Y) is incremented when you add functionality in a backwards-compatible manner:
  - Example: `v1.1.0`
- **PATCH** version (Z) is incremented when you make backwards-compatible bug fixes:
  - Example: `v1.0.1`

A version number looks like this: `MAJOR.MINOR.PATCH`, e.g., `1.2.3`.

**Commit Messages**:

To support semantic versioning, we use a convention for commit messages based on the [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) specification:

- **Types of Commits**:
  - **feat:** for a new feature for the user (which results in a minor version bump)
  - **fix:** for a bug fix (which results in a patch version bump)
  - **docs:** documentation only changes
  - **style:** changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc)
  - **refactor:** a code change that neither fixes a bug nor adds a feature
  - **perf:** a code change that improves performance
  - **test:** adding missing tests or correcting existing tests
  - **build:** changes that affect the build system or external dependencies
  - **ci:** changes to our CI configuration files and scripts
  - **chore:** other changes that don't modify src or test files
  - **revert:** reverts a previous commit

- **Format**:
  - `<type>[optional scope]: <description>`
    - Example: `fix: correct minor typos in code`
  - For breaking changes, include a `BREAKING CHANGE:` footer in the commit message:
    - Example:
      ```
      feat(api): add new endpoint for user profiles
      BREAKING CHANGE: The old endpoint `/user` is deprecated. Use `/user/profile` instead.
      ```

**Tagging Releases**:

- Each release should be tagged in Git with a version number like `v1.0.1`.
- Use annotated tags (`git tag -a v1.0.1 -m "Release version 1.0.1"`) to add meaningful descriptions to your tags.

**Branch Naming Guidelines**:

To keep our Git workflow organized and intuitive, we use the following conventions for naming branches:

- **Feature Branches**:
  - Prefix: `feature/`
  - Example: `feature/add-login-system`
  - Use for new features or enhancements that are not yet ready for the main branch.

- **Bug Fix Branches**:
  - Prefix: `fix/`
  - Example: `fix/resolve-login-issue`
  - Use for addressing specific bugs or issues.

- **Documentation Branches**:
  - Prefix: `docs/`
  - Example: `docs/update-readme`
  - Use for changes that only affect documentation.

- **Refactoring Branches**:
  - Prefix: `refactor/`
  - Example: `refactor/optimize-api-calls`
  - Use for code refactors that do not add features or fix bugs.

- **Performance Branches**:
  - Prefix: `perf/`
  - Example: `perf/reduce-memory-usage`
  - Use for performance improvements.

- **Testing Branches**:
  - Prefix: `test/`
  - Example: `test/add-unit-tests-for-auth`
  - Use for branches that are dedicated to adding or modifying tests.

- **Build and CI Branches**:
  - Prefix: `build/` or `ci/`
  - Examples: `build/update-node-version`, `ci/add-linting-step`
  - Use for changes related to build systems, CI/CD, or dependencies.

- **Hotfix Branches** (for urgent fixes):
  - Prefix: `hotfix/`
  - Example: `hotfix/critical-security-patch`
  - Use when you need to quickly fix something in production.

- **Release Branches** (if following Git Flow or similar):
  - Prefix: `release/`
  - Example: `release/v1.2`
  - Use for preparing a new production release, allowing for last-minute dotting of i's and crossing of t's.

**General Rules**:

- Use lowercase for branch names to avoid case sensitivity issues across different systems.
- Use hyphens (-) to separate words in branch names for readability.
- Be descriptive but concise; the branch name should convey the purpose of the branch.
- Avoid special characters in branch names except for hyphens, as they might not be supported in all environments.

By following these branch naming conventions, we can easily identify the purpose of each branch in our repository, which aids in managing the development workflow and simplifies code reviews and merges.

**Additional Guidelines**:

- Before creating a release, ensure all relevant changes are merged into the main branch (or release branch if following a branching model like Git Flow).
- After merging, bump the version in your project's metadata (like `package.json` for npm projects) using tools like `npm version` or manually if not using npm.
- Push the new tag to the remote repository: `git push origin --tags`.

By adhering to these practices, we ensure that our versioning is consistent, and users can understand the nature of changes between versions through clear commit messages and tags.[](https://stackoverflow.com/questions/15301174/how-do-i-implement-semantic-versioning-in-git)[](https://travishorn.com/semantic-versioning-with-git-tags-1ef2d4aeede6)[](https://www.freecodecamp.org/news/how-to-write-better-git-commit-messages/)

