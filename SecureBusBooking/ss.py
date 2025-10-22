import hashlib

def sha1_hash(text):
    return hashlib.sha1(text.encode()).hexdigest()

def create_rainbow_table(wordlist_path):
    rainbow_table = {}
    with open(wordlist_path, 'r', errors='ignore') as wordlist_file:
        for line in wordlist_file:
            password = line.strip()
            hashed_password = sha1_hash(password)
            rainbow_table[hashed_password] = password
    return rainbow_table

def crack_sha1_hash(target_hash, rainbow_table):
    return rainbow_table.get(target_hash, None)

def save_matched_hashes(matched_file, hash_value, password):
    with open(matched_file, 'a', encoding='utf-8') as matched_output:
        matched_output.write(f"{hash_value}:{password}\n")

# Example usage
if __name__ == "__main__":
    # Replace these with the actual paths
    linkedin_hashes_path = "C:\\Users\\Aly Ameen\\Desktop\\Linkedin.txt"
    rockyou_wordlist_path = "C:\\Users\\Aly Ameen\\Desktop\\rockyou.txt"
    newpassword_path = "C:\\Users\\Aly Ameen\\Desktop\\cracked_passwords.txt"

    # Create rainbow table
    rainbow_table = create_rainbow_table(rockyou_wordlist_path)

    # Crack LinkedIn hashes and save matches to newpassword file
    with open(linkedin_hashes_path, 'r') as linkedin_hashes_file:
        with open(newpassword_path, 'w') as newpassword_file:
            for line in linkedin_hashes_file:
                target_hash = line.strip()
                password = crack_sha1_hash(target_hash, rainbow_table)
                if password:
                    save_matched_hashes(newpassword_file, target_hash, password)

    print(f"Cracking complete. Check cracked_passwords.txt for results.")
