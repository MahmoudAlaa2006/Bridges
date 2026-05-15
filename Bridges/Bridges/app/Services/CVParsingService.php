<?php

namespace App\Services;

use App\Models\Skill;

class CVParsingService
{
    
    public function parseCV(string $cvContent): array
    {
        $cvText = strtolower($cvContent);

        $allSkills = Skill::all(['skill_id', 'name'])->toArray();
        $extractedSkills = [];
        $skillMatches = [];
        
        foreach ($allSkills as $skill) {
            $skillName = strtolower($skill['name']);

            if (preg_match('/\b' . preg_quote($skillName, '/') . '\b/i', $cvContent)) {
                $extractedSkills[] = [
                    'skill_id' => $skill['skill_id'],
                    'name' => $skill['name'],
                    'found' => true,
                ];
                $skillMatches[$skill['skill_id']] = true;
            }
        }

        $yearsExperience = $this->extractExperienceYears($cvContent);

        $educationLevel = $this->extractEducationLevel($cvContent);

        $certifications = $this->extractCertifications($cvContent);
        
        return [
            'skills' => $extractedSkills,
            'years_experience' => $yearsExperience,
            'education_level' => $educationLevel,
            'certifications' => $certifications,
            'skill_count' => count($extractedSkills),
            'raw_text' => $cvContent,
        ];
    }

    private function extractExperienceYears(string $cvContent): int
    {

        $patterns = [
            '/(\d{1,2})\s*\+?\s*years?\s*(?:of\s*)?experience/i',
            '/exp[^:]*:\s*(\d{1,2})\s*years?/i',
            '/experience[^:]*:\s*(\d{1,2})\s*years?/i',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $cvContent, $matches)) {
                return (int) $matches[1];
            }
        }

        if (preg_match_all('/(\d{4})[^0-9]*(\d{4})/', $cvContent, $matches)) {
            $totalYears = 0;
            for ($i = 0; $i < count($matches[1]); $i++) {
                $years = (int)$matches[2][$i] - (int)$matches[1][$i];
                if ($years > 0 && $years < 60) {
                    $totalYears += $years;
                }
            }
            return min($totalYears, 50);
        }
        
        return 0;
    }

    private function extractEducationLevel(string $cvContent): string
    {
        $cvLower = strtolower($cvContent);
        
        if (preg_match('/phd|doctorate|dr\./i', $cvContent)) {
            return 'Doctorate';
        }
        if (preg_match('/master|m\.s\.|m\.a\.|mba/i', $cvContent)) {
            return 'Masters';
        }
        if (preg_match('/bachelor|b\.s\.|b\.a\.|b\.sc\./i', $cvContent)) {
            return 'Bachelor';
        }
        if (preg_match('/associate|diploma/i', $cvContent)) {
            return 'Associate';
        }
        if (preg_match('/high school|high-school|hsd/i', $cvContent)) {
            return 'High School';
        }
        
        return 'Not Specified';
    }

    private function extractCertifications(string $cvContent): array
    {
        $certifications = [];
        $patterns = [
            '/certification[s]?[^a-z]*([A-Za-z0-9\s\-,]+?)(?:certification|$)/i',
            '/certified[^a-z]*([A-Za-z0-9\s\-,]+?)(?:certification|$)/i',
            '/(AWS|AWS\s+Certified|Google\s+Cloud|Azure|Kubernetes|Docker|CISSP|PMP|SCRUM)/i',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern, $cvContent, $matches)) {
                foreach ($matches[1] as $match) {
                    $cert = trim($match);
                    if (strlen($cert) > 3 && strlen($cert) < 100) {
                        $certifications[] = $cert;
                    }
                }
            }
        }
        
        return array_unique($certifications);
    }

    public function extractTextFromPDF(string $filePath): string
    {

        return '';
    }
}
